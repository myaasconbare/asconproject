<?php

namespace App\Filament\Resources;

use App\Enums\WithdrawalStatus;
use App\Filament\Resources\WithdrawalResource\Pages;
use App\Filament\Resources\WithdrawalResource\RelationManagers;
use App\Models\Setting;
use App\Models\Withdrawal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WithdrawalResource extends Resource
{
    protected static ?string $model = Withdrawal::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Withdrawals';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->latest('id');
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
        $SiteSettings = Setting::first();

        $percentageFee = $SiteSettings ? (float) $SiteSettings->payout_percentage_fee : 0.00;

        
        // $amount = $payout->amount - $payoutFee;

        return $table
            ->columns([
                TextColumn::make('user.email')
                ->description(fn(Model $record) => $record->user->name)
                ->searchable(['email', 'name']),
                TextColumn::make('currency.name')
                ->label('Currency'),
                TextColumn::make('user.deposit_wallet')
                    ->description(fn(Model $record) => $record->user->deposit_wallet)
                    ->searchable(['deposit_wallet']),
                TextColumn::make('amount')
                    ->state(function(Model $record) use($percentageFee) {
                            $payoutFee = (((float) $percentageFee) / 100) * $record->amount;
                            return $record->amount - $payoutFee;
                    })
                    ->money('USD'),
                TextColumn::make('charge')
                    ->state(function(Model $record) use($percentageFee) {
                            $payoutFee = (((float) $percentageFee) / 100) * $record->amount;
                            return $record->charge ?? $payoutFee;
                    })
                    ->money('USD'),
                TextColumn::make('user_wallet_address')
                    ->label('wallet address')
                    ->copyable(),
                TextColumn::make('wallet')
                ->badge()
                ->color('success')
                ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => WithdrawalStatus::getColor($state))
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Date'),  


            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Action::make('View User')
                // ->label('View User')
                ->color('info')
                ->button()
                ->action(fn(Model $record) => redirect(UserResource::getUrl('index', ['tableSearch' => $record->user->email]))),
                ActionGroup::make([
                    ActionGroup::make([
                        Action::make('approve')
                            ->action(fn(Model $record) => 
                                static::handlePayoutAction($record, 'approve')
                            )
                            ->color('success')
                            // ->visible(fn() => self::shouldBeVisibleIn(['pending', 'process']))
                        ,
                        Action::make('decline')
                            ->action(function(Model $record) {
                                static::handlePayoutAction($record, action:'decline');
                            })
                            ->color('danger')
                            // ->visible(fn() => self::shouldBeVisibleIn(['pending']))
                            ,
                        Action::make('set to pending')
                            ->action(fn(Model $record) => 
                                static::handlePayoutAction($record, 'pending')
                            )
                            ->color('warning')
                            // ->visible(fn() => self::shouldBeVisibleIn(['pending', 'process']))
                        ,
                    ])->dropdown(false),
                    Action::make('delete')
                        ->action(fn(Model $record) => 
                            self::handlePayoutAction($record, 'delete')
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
            'index' => Pages\ListWithdrawals::route('/'),
            'create' => Pages\CreateWithdrawal::route('/create'),
            // 'edit' => Pages\EditWithdrawal::route('/{record}/edit'),
        ];
    }
}
