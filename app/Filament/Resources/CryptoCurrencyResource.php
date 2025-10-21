<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CryptoCurrencyResource\Pages;
use App\Filament\Resources\CryptoCurrencyResource\RelationManagers;
use App\Models\CryptoCurrency;
use App\Traits\Admin\Notify;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CryptoCurrencyResource extends Resource
{
    use Notify;

    protected static ?string $model = CryptoCurrency::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Trade';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        // $table->string('name', 190);
        // $table->string('pair', 190);
        // $table->string('crypto_id', 190);
        // $table->text('image')->nullable();
        // $table->string('symbol', 20);
        // $table->boolean('is_active')->default(1);
        // $table->tinyInteger('top_gainer')->nullable();
        // $table->tinyInteger('top_loser')->nullable();

        return $table
            ->columns([
                ImageColumn::make('image'),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('pair')
                    ->searchable(),
                TextColumn::make('meta.price_change_24h')
                    ->label('Daily Change')
                    ->copyable()
                    ->searchable('meta.price_change_24h'),
                TextColumn::make('meta.market_cap')
                    ->label('Market Cap')
                    ->copyable(),
                TextColumn::make('meta.high_24h')
                    ->label('Daily High')
                    ->copyable(),
                TextColumn::make('meta.low_24h')
                    ->label('Daily Low')
                    ->copyable(),
                TextColumn::make('symbol')
                    ->state(fn(Model $record) => strtoupper($record->symbol))
                    ->searchable()
                    ->copyable(),
                IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
               

                Action::make('disable')
                    ->label(fn(Model $record) => $record->is_active ? 'Disable' : 'Enable')
                    ->button()
                    ->outlined()
                    ->color(fn(Model $record) => $record->is_active ? 'danger' : 'success')
                    ->requiresConfirmation()
                    ->action(function(Model $record) {
                        $record->update(['is_active' => !$record->is_active]);
                        
                        (new self)->notify('success', 'Currency Updated successfully');
                    })
                    // ->visible(fn(Model $record) => $record->is_active),
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
            'index' => Pages\ListCryptoCurrencies::route('/'),
            'create' => Pages\CreateCryptoCurrency::route('/create'),
            // 'edit' => Pages\EditCryptoCurrency::route('/{record}/edit'),
        ];
    }
}
