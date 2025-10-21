<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StakingPlanResource\Pages;
use App\Filament\Resources\StakingPlanResource\RelationManagers;
use App\Models\StakingPlan;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StakingPlanResource extends Resource
{
    protected static ?string $model = StakingPlan::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Staking Investment';
    protected static ?string $navigationLabel = 'Plans';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('minimum_amount')
                    ->placeholder('Enter Amount')
                    ->prefix('$')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->columnSpan(1)
                    ->required(),
                TextInput::make('maximum_amount')
                    ->placeholder('Enter Amount')
                    ->prefix('$')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->columnSpan(1)
                    ->required(),
                TextInput::make('interest_rate')
                    ->placeholder('Enter Interest Rate')
                    ->prefix('$')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->columnSpan(1)
                    ->required(),
                TextInput::make('duration')
                    ->integer()
                    ->placeholder('Enter duration')
                    ->required(),
                Select::make('period')
                    ->options([
                        'hours' => 'Hour(s)',
                        'days' => 'Day(s)',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('minimum_amount')
                ->money('USD'),
            TextColumn::make('maximum_amount')
                ->money('USD'),
            TextColumn::make('interest_rate')
                ->suffix('%'),
            TextColumn::make('duration')
                ->state(fn(Model $record) => $record->duration_label)
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                DeleteAction::make(),
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
            'index' => Pages\ListStakingPlans::route('/'),
            'create' => Pages\CreateStakingPlan::route('/create'),
            'edit' => Pages\EditStakingPlan::route('/{record}/edit'),
        ];
    }
}
