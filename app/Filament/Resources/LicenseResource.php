<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LicenseResource\Pages;
use App\Filament\Resources\LicenseResource\RelationManagers;
use App\Models\License;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

class LicenseResource extends Resource
{
    protected static ?string $model = License::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Investment';

   


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('portfolio_id')
                ->relationship(name:'portfolio', titleAttribute:'name')
                ->native(false)
                ->preload()
                ,

                TextInput::make('minimum_amount')
                    ->placeholder('Enter minimum amount')
                    ->prefix('$')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->columnSpan(1),
                Select::make('is_unlimited')
                    ->label('Maximum amount type')
                    ->options([
                        false => 'Fixed',
                        true => 'Unlimited',
                    ])
                    ->default(false)
                    ->live(),
                TextInput::make('maximum_amount')
                    ->placeholder('Enter maximum amount')
                    ->prefix('$')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->columnSpan(1)
                    ->hidden(fn(Get $get) => $get('is_unlimited') || $get('is_fixed'))
                    ->requiredUnless('is_unlimited', true)
                    ->validationMessages([
                        'required_unless' => 'Maximum amount is required'
                    ]),

                TextInput::make('minimum_interest_rate')
                    ->placeholder('Enter Interest Rate')
                    ->prefix('$')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->columnSpan(1)
                    ->required(),

                TextInput::make('maximum_interest_rate')
                    ->placeholder('Enter Interest Rate')
                    ->prefix('$')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->columnSpan(1)
                    ->required(),
                // TextInput::make('duration')
                //     ->required(),
                // Select::make('period')
                //     ->label('Period')
                //     ->options([
                //         'hours' => 'Hour(s)',
                //         'days' => 'Day(s)',
                //     ])
                //     ->default('days')
                //     ->required()
                //     ->columnSpan(fn(Get $get) => $get('is_unlimited') ? 2 : 1),

                // Textarea::make('terms')
                //     ->columnSpanFull(),
                // Section::make('Features')
                //     ->schema([
                //         Repeater::make('features')
                //             ->label('')
                //             ->schema([
                //                 TextInput::make('feature')
                //                     ->label("")
                //             ])
                //             ->columnSpanFull()
                //             ->addActionLabel('Add More Feature'),
                //             ]),
                // Toggle::make('is_recommended')
                //     ->label('Recommend Plan?')

            ]);
        }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Split::make([
                    TextColumn::make('portfolio.name'),
                    
                    TextColumn::make('minimum_amount')
                        ->money('USD')
                        ->hidden(fn ($livewire) => $livewire->activeTab == 'Fixed'),
                    
                    TextColumn::make('maximum_amount')
                        ->state(fn(Model $record) => $record->is_unlimited ? $record->maximum_amount_label : Number::currency($record->maximum_amount_label))
                        ->hidden(fn ($livewire) => $livewire->activeTab == 'Fixed')
                        ,
                    TextColumn::make('minimum_interest_rate')
                        ->label('Interest Range')
                        ->formatStateUsing(fn(Model $record) => $record->minimum_interest_rate. '% - ' . $record->maximum_interest_rate)
                        ->suffix('%'),
                    TextColumn::make('rate')
                        ->label('Computed Rate')
                        ->numeric(decimalPlaces: 2)
                        // ->
                        // ->formatStateUsing(fn(Model $record) => $record->rate)
                        ->suffix('%'),
                        // Stack::make([
                        //     TextColumn::make('duration'),
                        //     TextColumn::make('period'),
                        // ]),,
                // ])
            
            ])
            ->filters([
                Filter::make('is_unlimited')
                ->label('Show Unlimited')
                ->query(fn (Builder $query) => $query->where('is_unlimited', true)),
            ], layout: FiltersLayout::Dropdown)
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
            'index' => Pages\ListLicenses::route('/'),
            'create' => Pages\CreateLicense::route('/create'),
            'edit' => Pages\EditLicense::route('/{record}/edit'),
        ];
    }
}
