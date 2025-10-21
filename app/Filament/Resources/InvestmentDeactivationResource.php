<?php

namespace App\Filament\Resources;

use App\Enums\InvestmentDeactivationStatus;
use App\Filament\Resources\InvestmentDeactivationResource\Pages;
use App\Filament\Resources\InvestmentDeactivationResource\RelationManagers;
use App\Models\InvestmentDeactivation;
use App\Services\InvestmentService;
use App\Traits\Admin\Notify;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvestmentDeactivationResource extends Resource
{
    use Notify;

    protected static ?string $model = InvestmentDeactivation::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Investment';
    protected static ?string $modelLabel = 'Deactivation';


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            // ->where('status', InvestmentDeactivationStatus::APPROVED)
            // ->whereIn('state', [ApprovedInvestmentState::PENDING_DEACTIVATION, ApprovedInvestmentState::DEACTIVATED])
            ->latest('id');
    }

    public static function handleInvestmentAction ($record, $action) { 
        $investmentService = resolve(InvestmentService::class);

        $response = match($action) {
            'approve' => $investmentService->approveDeactivation($record->id),
            'decline' => $investmentService->declineDeactivation($record->id),
        };

        static::showResponse($response);
        return null;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('user.avatar_url')
                ->circular(),
                TextColumn::make('user.email')
                    ->description(fn(Model $record) => $record->user->name)
                    ->searchable(['email', 'name'])
                    ->label('user'),
                TextColumn::make('investment.reference_id')
                        ->searchable(['reference_id'])
                        ->label('Reference')
                        ->badge()
                        ->color('success')
                        ->searchable()
                        ->copyable(),
                TextColumn::make('investment.license.name')
                    
                    ->label('Plan'),
                
                TextColumn::make('amount')
                    ->money('USD')
                    ->label('Capital')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => InvestmentDeactivationStatus::getColor($state))
                    ->searchable(),
            ])
            ->filters([
                Filter::make('plans')
                ->form([
                    Select::make('plan_type')
                        ->options([
                            'flexi' => 'Flexi Plans',
                            'normal' => 'With Normal Plans',
                        ])
                        // ->default('normal')
                ])
                ->query(function (Builder $query, array $data): Builder {
                    // dd($data);
                    return $query->when(
                        $data['plan_type'] == 'normal', 
                        fn (Builder $query) => $query->withWhereHas('investment.plan')
                    )
                    ->when(
                        $data['plan_type'] == 'flexi', 
                        fn (Builder $query) => $query->withWhereHas('investment.flexiPlan')
                    );
                })
            ])
            ->actions([
                 // EditAction::make(),
                 Action::make('View User')
                 // ->label('View User')
                 ->color('info')
                 ->button()
                 ->action(fn(Model $record) => redirect(UserResource::getUrl('index', ['tableSearch' => $record->user->email]))),
                 ActionGroup::make([
                     ActionGroup::make([
                 
                         Action::make('approve')
                             ->action(fn(InvestmentDeactivation $record) => 
                                 static::handleInvestmentAction($record, action: 'approve')
                             )
                             ->color('success'),
                             // ->visible(fn(InvestmentDeactivation $deposit) => $deposit->approved_at && $deposit->running),
                         Action::make('decline')
                             ->action(fn(InvestmentDeactivation $record) => 
                                 static::handleInvestmentAction($record, action: 'decline')
                             )
                             ->color('info'),
                         
                     ])->dropdown(false),
                     Action::make('delete')
                         ->action(fn(InvestmentDeactivation $record) => 
                             self::handleInvestmentAction($record, 'delete')
                         )
                         ->color('danger')
                         ->requiresConfirmation()
                 ])
                 ->label('actions')
                 ->icon('heroicon-m-ellipsis-vertical')
                 ->size(ActionSize::Small)
                 ->color('primary')
                 ->button('primary'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvestmentDeactivations::route('/'),
            'create' => Pages\CreateInvestmentDeactivation::route('/create'),
            'edit' => Pages\EditInvestmentDeactivation::route('/{record}/edit'),
        ];
    }
}
