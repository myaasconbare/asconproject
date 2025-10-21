<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MatrixEnrollmentResource\Pages;
use App\Filament\Resources\MatrixEnrollmentResource\RelationManagers;
use App\Models\MatrixEnrollment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MatrixEnrollmentResource extends Resource
{
    protected static ?string $model = MatrixEnrollment::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Matrix Scheme';

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
                TextColumn::make('user.email')
                    ->searchable(),
                TextColumn::make('transaction_id')
                    ->searchable()
                    ->label('trx'),
                TextColumn::make('amount')
                    ->searchable()
                    ->money('USD'),
                TextColumn::make('referral_commission')
                    ->money('USD'),
                TextColumn::make('level_commission')
                    ->money('USD'),
                TextColumn::make('status')
                    ->badge()
                    ->color(function($state){
                        return match($state){
                            'running' => 'warning',
                            'completed' => 'success',
                        };
                    }),
                TextColumn::make('created_at')
                    ->state(fn(Model $record) => $record->initiated_at)
                    ->label('Initiated At'),

            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->recordUrl(null);
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
            'index' => Pages\ListMatrixEnrollments::route('/'),
            'create' => Pages\CreateMatrixEnrollment::route('/create'),
            'edit' => Pages\EditMatrixEnrollment::route('/{record}/edit'),
        ];
    }
}
