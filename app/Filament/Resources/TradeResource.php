<?php

namespace App\Filament\Resources;

use App\Enums\TradeOutcome;
use App\Enums\TradeStatus;
use App\Enums\TradeTypes;
use App\Enums\TradeVolume;
use App\Filament\Resources\TradeResource\Pages;
use App\Filament\Resources\TradeResource\RelationManagers;
use App\Models\Trade;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Number;

class TradeResource extends Resource
{
    protected static ?string $model = Trade::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Trade';


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
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable(['email', 'name'])
                    ->description(fn(Model $record) => $record->user->email),
                TextColumn::make('cryptoCurrency.name')
                    ->searchable(['name', 'pair'])
                    ->description(fn(Model $record) => $record->cryptoCurrency->pair),
                TextColumn::make('amount')
                    ->money('USD'),
                TextColumn::make('meta')
                    ->label('Result Price')
                    ->state(fn(Model $record) => $record->meta['result_price'])
                    ->money('USD')
                    ,
                TextColumn::make('original_price')
                    ->label('Trade Price')
                    ->formatStateUsing(fn(Model $record) => sprintf("1 %s = %s", strtoupper($record->cryptoCurrency->symbol), Number::currency($record->original_price)))

                    ,

                    TextColumn::make('type')
                    ->formatStateUsing(fn(string $state) => strtoupper($state))
                    ->badge()
                    ->color(function(string $state) {
                        return match($state) {
                            TradeTypes::TRADE->value => 'success',
                            TradeTypes::PRACTICE->value => 'info',
                        };
                    }),

                TextColumn::make('volume')
                    ->formatStateUsing(fn(Model $record) => $record->volume_label)
                    ->badge()
                    ->color(function(string $state) {
                        return match($state) {
                            TradeVolume::HIGH->value => 'success',
                            TradeVolume::LOW->value => 'danger',
                        };
                    }),
                TextColumn::make('outcome')
                    ->formatStateUsing(fn(Model $record) => strtoupper(TradeOutcome::from($record->outcome)->value))
                    ->badge()
                    ->color(function(string $state) {
                        return match($state) {
                            TradeOutcome::INITIATED->value => 'warning',
                            TradeOutcome::WIN->value => 'success',
                            TradeOutcome::LOSE->value => 'danger',
                            TradeOutcome::DRAW->value => 'primary',
                        };
                    }),
                TextColumn::make('status')
                    ->formatStateUsing(fn(Model $record) => strtoupper(TradeStatus::from($record->status)->value))
                    ->badge()
                    ->color(function(string $state) {
                        return match($state) {
                            TradeStatus::RUNNING->value => 'info',
                            TradeStatus::COMPLETE->value => 'success',
                        };
                    }),
                TextColumn::make('created_at')
                    ->label("Initiated At")
                    ->since()
                    ->dateTimeTooltip()
                   
            ])
            ->filters([
                 SelectFilter::make('type')
                    ->label('Trade Type')
                    ->options(TradeTypes::options()),
                // Filter::make('is_unlimited')
                // ->label('Show Unlimited')
                // ->query(fn (Builder $query) => $query->where('is_unlimited', true))
                // ->visible(fn ($livewire) => $livewire->activeTab == 'Range'),
            ])
            ->actions([
                DeleteAction::make()
                    ->button()
                    ->outlined(),
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListTrades::route('/'),
            'create' => Pages\CreateTrade::route('/create'),
            // 'edit' => Pages\EditTrade::route('/{record}/edit'),
        ];
    }
}
