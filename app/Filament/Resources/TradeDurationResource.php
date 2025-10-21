<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TradeDurationResource\Pages;
use App\Filament\Resources\TradeDurationResource\RelationManagers;
use App\Models\TradeDuration;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TradeDurationResource extends Resource
{
    protected static ?string $model = TradeDuration::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Trade';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('duration')
                    ->columnSpanFull(),
                Select::make('period')
                    ->columnSpanFull()
                    ->options([
                        // 'seconds' => 'Second(s)',
                        'minutes' => 'Minute(s)',
                        'hours' => 'Hour(s)',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('duration'),
                TextColumn::make('period_label'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth('md'),
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
            'index' => Pages\ListTradeDurations::route('/'),
            // 'create' => Pages\CreateTradeDuration::route('/create'),
            // 'edit' => Pages\EditTradeDuration::route('/{record}/edit'),
        ];
    }
}
