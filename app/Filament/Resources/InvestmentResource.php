<?php

namespace App\Filament\Resources;

use App\Enums\InvestmentStatus;
use App\Filament\Resources\InvestmentResource\Pages;
use App\Filament\Resources\InvestmentResource\RelationManagers;
use App\Models\Investment;
use App\Models\License;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvestmentResource extends Resource
{
    protected static ?string $model = Investment::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Investment';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('license_id')
                    ->options(function(Model $record) {
                        $licenses = License::with(['portfolio'])->get();

                        $values = $licenses->map(fn($license) => "{$license->portfolio->name} : {$license->minimum_amount_format} - {$license->maximum_amount_format}" )
                                ->toArray();
                        $keys = $licenses->pluck('id')->toArray();

                        return array_combine($keys, $values);
                    })
                    ->required()
                    ->label('License'),
                TextInput::make('amount')
                ->prefix('$')
                ->mask(RawJs::make('$money($input)'))
                ->stripCharacters(',')
                ->numeric()
                ->columnSpan(1)
                ->required(),
                TextInput::make('interests_received')
                ->label('Profit Received')
                ->prefix('$')
                ->mask(RawJs::make('$money($input)'))
                ->stripCharacters(',')
                ->numeric()
                ->columnSpan(1)
                ->required(),
                TextInput::make('run_times')
                ->label('Investment Run Times')
                ->suffix(' time(s)')
                ->required(),
                
                // ViewColumn::make('upcoming payment')->view('tables.columns.progress-bar'),
                DateTimePicker::make('created_at')
                ->label('Invested on'),
                DateTimePicker::make('last_interest_date')
                ->label('Last Interest Date'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('user.avatar_url')
                    ->label('image')
                    ->circular(),
                TextColumn::make('user.email')
                    ->description(fn(Model $record) => $record->user->name)
                    ->searchable(['email', 'name'])
                    ->label('user'),
                TextColumn::make('reference_id')
                    ->badge()
                    ->color('success')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('license.name')
                    // ->formatStateUsing(fn(Model $record) => "{$state} Plan")
                    ->searchable()
                    ->label('Plan'),
               
                // TextColumn::make('user.email'),
                TextColumn::make('amount')
                ->money('USD')
                ->searchable(),
                TextColumn::make('interests_received')
                ->label('Profit Received')
                ->money('USD')
                ->searchable(),
                TextColumn::make('run_times')
                ->label('Investment Run Times')
                ->suffix(' time(s)')
                ->searchable(),
                
                // ViewColumn::make('upcoming payment')->view('tables.columns.progress-bar'),
                TextColumn::make('created_at')
                ->label('Invested on'),
                TextColumn::make('last_payment')
                ->label('Last Interest Date'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                Action::make('deactivation')
                    ->visible(fn(Model $record) => $record->status == InvestmentStatus::PENDING_TERMINATION->value)
                    ->label('Deactivation Page')
                    ->outlined()
                    ->button()
                    ->action(fn(Model $record) => redirect(InvestmentDeactivationResource::getUrl('index', ['tableSearch' => $record->reference_id])))
                    ->color('success'),
                Action::make('View User')
                // ->label('View User')
                ->color('info')
                ->button()
                ->action(fn(Model $record) => redirect(UserResource::getUrl('index', ['tableSearch' => $record->user->email]))),
                ActionGroup::make([
                    ActionGroup::make([
                
                        // Action::make('pause')
                        //     ->action(fn(Investment $record) => 
                        //         static::handleInvestmentAction($record, action: 'pause')
                        //     )
                        //     ->color('info'),
                            // ->visible(fn(Investment $deposit) => $deposit->approved_at && $deposit->running),
                        // Action::make('resume')
                        //     ->action(fn(Investment $record) => 
                        //         static::handleInvestmentAction($record, action: 'resume')
                        //     )
                        //     ->color('warning'),
                        Action::make('Complete Investment')
                            ->action(fn(Investment $record) => 
                                static::handleInvestmentAction($record, action: 'complete')
                            )
                            ->color('success')
                    ])->dropdown(false),
                    Action::make('delete')
                        ->action(fn(Investment $record) => 
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
                BulkActionGroup::make([
                    DeleteBulkAction::make(),

                ]),
            ])
            ->recordUrl('');
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
            'index' => Pages\ListInvestments::route('/'),
            'create' => Pages\CreateInvestment::route('/create'),
            'edit' => Pages\EditInvestment::route('/{record}/edit'),
        ];
    }
}
