<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepositResource\Pages;
use App\Filament\Resources\DepositResource\RelationManagers;
use App\Models\Deposit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Enums\Transaction;
use Filament\Support\Enums\ActionSize;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Illuminate\Database\Eloquent\Model;

class DepositResource extends Resource
{
    protected static ?string $model = Deposit::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Deposit';

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
                TextColumn::make('user.name')
                ->searchable(['email', 'name'])
                ->description(fn(Model $record) => $record->user->email),
                // TextColumn::make('user.email'),
                TextColumn::make('total_deposited')
                    ->money('USD')
                    
                    ->state(fn($record) => $record->charge + $record->amount),
                TextColumn::make('amount_credited')
                ->state(function($record) {
                    return match($record->status) {
                        Transaction\Status::APPROVED->value => $record->amount,
                        default => 0.00,
                    };
                })
                ->money('USD'),
                
                TextColumn::make('amount in currency')
                ->state(fn(Deposit $record) => ("{$record->pay_amount} " . strtoupper($record->currency))),
                // TextColumn::make('currency'),
                TextColumn::make('charge')
                ->money('USD'),
                TextColumn::make('status')
                
                ->badge()
                ->color(fn (string $state): string => Transaction\Status::getColor($state))
                ->searchable(),
                TextColumn::make('destination_wallet_address')
                ->badge()
                ->size('xs')
                ->color('success')
                ->copyable()
                ->searchable()
                ->wrap(),
                TextColumn::make('created_at')
                ->label('Date'),
            ])
            ->filters([
                //
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
                            ->action(fn(Deposit $record) => 
                                static::handleDepositAction($record, 'approve')
                            )
                            ->color('success')
                        ,
                        Action::make('decline')
                            ->action(fn(Deposit $record) => 
                                // static::declineDeposit($record)
                                static::handleDepositAction($record, action:'decline')
                            )
                            ->color('warning')
                            ,
                    ])->dropdown(false),
                    Action::make('delete')
                        ->action(fn(Deposit $record) => 
                            self::handleDepositAction($record, 'delete')
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
            
            // ->emptyStateActions([
            //     CreateAction::make(),
            // ]);
    
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
            'index' => Pages\ListDeposits::route('/'),
            'create' => Pages\CreateDeposit::route('/create'),
            // 'edit' => Pages\EditDeposit::route('/{record}/edit'),
        ];
    }
}
