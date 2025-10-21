<?php

namespace App\Filament\Resources;

use App\Enums\StakingInvestmentStatus;
use App\Filament\Resources\StakingInvestmentResource\Pages;
use App\Filament\Resources\StakingInvestmentResource\RelationManagers;
use App\Models\StakingInvestment;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StakingInvestmentResource extends Resource
{
    protected static ?string $model = StakingInvestment::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Staking Investment';
    protected static ?string $navigationLabel = 'Records';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->latest('id');
    }

    public static function form(Form $form): Form
    {
        // $table->enum('period', Periods::values());

        return $form
            ->schema([
               
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.email'),
                TextColumn::make('amount')
                    ->money('USD'),
                TextColumn::make('interest')
                    ->suffix('%'),
                TextColumn::make('total_return')
                    ->money('USD'),
                TextColumn::make('status')
                    ->color(fn(string $state) => StakingInvestmentStatus::getStatusColor($state))
                    ->badge(),
                TextColumn::make('created_at')
                    ->state(fn(Model $record) => $record->initiated_at)
                    ->label('Initiated At'),
                TextColumn::make('expires_at')
                    ->state(fn(Model $record) => $record->formatDate('expires_at'))
                    ->label('Expires On'),
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
            'index' => Pages\ListStakingInvestments::route('/'),
            'create' => Pages\CreateStakingInvestment::route('/create'),
            'edit' => Pages\EditStakingInvestment::route('/{record}/edit'),
        ];
    }
}
