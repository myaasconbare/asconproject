<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MatrixPlanResource\Pages;
use App\Filament\Resources\MatrixPlanResource\RelationManagers;
use App\Models\MatrixPlan;
use App\Services\MatrixService;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MatrixPlanResource extends Resource
{
    protected static ?string $model = MatrixPlan::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Matrix Scheme';

    public static function form(Form $form): Form
    {
        $matrixService = resolve(MatrixService::class);
        $matrixHeight = $matrixService->getMatrixSettings()->height;

        $commissionSchema = [];

        for($i = 1; $i <= $matrixHeight; $i++){
            $field = TextInput::make('level_' . $i)
                        ->placeholder('Enter Level ' . $i . ' commission')
                        ->prefix('$')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric()
                        ->required();
            array_push($commissionSchema, $field);
        }

        return $form
            ->schema([
                TextInput::make('name')
                    ->placeholder('Enter name')
                    ->required(),
                TextInput::make('amount')
                    ->placeholder('Enter amount')
                    ->prefix('$')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->columnSpan(1)
                    ->required(),
                TextInput::make('referral_reward')
                    ->placeholder('Enter reward')
                    ->prefix('$')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->columnSpan(1)
                    ->required(),
                Select::make('is_active')
                    ->label('Status')
                    ->options([
                        1 => 'Active',
                        0 => 'Disabled',
                    ])
                    ->default(1),
                Repeater::make('commission')
                    ->label('Referral Commission')
                    ->schema($commissionSchema)
                    ->reorderable(false)
                    ->addable(false)
                    ->columnSpanFull()
                    ->deletable(false)
                    ,
                Toggle::make('is_recommended')
                    ->label('Recommend Plan?'),
                // Toggle::make('is_active')
                //     ->label('Active Plan?')
                //     ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('amount')
                    ->money('USD'),
                TextColumn::make('referral_reward')
                    ->money('USD'),
                IconColumn::make('is_active')
                    ->boolean(),
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
            'index' => Pages\ListMatrixPlans::route('/'),
            'create' => Pages\CreateMatrixPlan::route('/create'),
            'edit' => Pages\EditMatrixPlan::route('/{record}/edit'),
        ];
    }
}
