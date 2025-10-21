<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WithdrawalCurrencyResource\Pages;
use App\Filament\Resources\WithdrawalCurrencyResource\RelationManagers;
use App\Models\WithdrawalCurrency;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WithdrawalCurrencyResource extends Resource
{
    protected static ?string $model = WithdrawalCurrency::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Withdrawals';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                TextInput::make('name')
                ->required(),
                // TextInput::make('ticker_symbol')
                // ->required(),
                Select::make('is_active')
                ->label('state')
                ->options([
                    true => 'Active',
                    false => 'Inactive',
                ])
                ->default(true)
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // ImageColumn::make('')
                //     ->state(function (Currency $asset) {
                //         return $asset->asset_url;
                //     }),
                TextColumn::make('name'),
                // TextColumn::make('ticker_symbol'),
                IconColumn::make('is_active')
                ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListWithdrawalCurrencies::route('/'),
            'create' => Pages\CreateWithdrawalCurrency::route('/create'),
            'edit' => Pages\EditWithdrawalCurrency::route('/{record}/edit'),
        ];
    }
}
