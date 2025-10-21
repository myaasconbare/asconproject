<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RewardBadgeResource\Pages;
use App\Filament\Resources\RewardBadgeResource\RelationManagers;
use App\Models\RewardBadge;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class RewardBadgeResource extends Resource
{
    protected static ?string $model = RewardBadge::class;
    protected static ?string $navigationGroup = 'Settings';


    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
    

        return $form
            ->schema([
                TextInput::make('level')
                    ->prefix('level_')
                    ->placeholder('1')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('minimum_invest')
                    ->prefix('$')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->required(),
                TextInput::make('minimum_team_invest')
                    ->prefix('$')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->required(),
                TextInput::make('minimum_deposit')
                    ->prefix('$')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->required(),
                TextInput::make('minimum_referral_count')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->required(),
                TextInput::make('reward')
                    ->prefix('$')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('level')
                    ->prefix('level_'),
                TextColumn::make('minimum_invest')
                    ->money('USD'),
                TextColumn::make('minimum_team_invest')
                    ->money('USD'),
                TextColumn::make('minimum_deposit')
                    ->money('USD'),
                TextColumn::make('minimum_referral_count'),
                TextColumn::make('reward')
                    ->money('USD'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListRewardBadges::route('/'),
            'create' => Pages\CreateRewardBadge::route('/create'),
            'edit' => Pages\EditRewardBadge::route('/{record}/edit'),
        ];
    }
}
