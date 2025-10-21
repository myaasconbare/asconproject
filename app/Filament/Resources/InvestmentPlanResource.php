<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvestmentPlanResource\Pages;
use App\Filament\Resources\InvestmentPlanResource\RelationManagers;
use App\Models\Investment;
use App\Models\InvestmentPlan;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
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
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvestmentPlanResource extends Resource
{
    protected static ?string $model = InvestmentPlan::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Investment';

    protected static bool $shouldRegisterNavigation = false;



    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                TextInput::make('name')
                    ->placeholder('Enter plan name')
                    ->columnSpan(1)
                    ->required(),
                Select::make('is_fixed')
                    ->label('Amount type')
                    ->options([
                        0 => 'Range',
                        1 => 'Fixed',
                    ])
                    ->default(0)
                    ->live()
                    ->required(),
                TextInput::make('amount')
                    ->placeholder('Enter amount')
                    ->prefix('$')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->columnSpan(1)
                    ->required()
                    ->visible(fn(Get $get) => $get('is_fixed')),
                TextInput::make('minimum_amount')
                    ->placeholder('Enter minimum amount')
                    ->prefix('$')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->columnSpan(1)
                    ->requiredIf('is_fixed', 'range')
                    ->hidden(fn(Get $get) => $get('is_fixed')),
                Select::make('is_unlimited')
                    ->label('Maximum amount type')
                    ->options([
                        false => 'Fixed',
                        true => 'Unlimited',
                    ])
                    ->default(false)
                    ->live()
                    ->hidden(fn(Get $get) => $get('is_fixed'))
                    ->requiredIf('is_fixed', 'range'),
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

                TextInput::make('interest_rate')
                    ->placeholder('Enter Interest Rate')
                    ->prefix('$')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->columnSpan(1)
                    ->required(),
                TextInput::make('duration')
                    ->required(),
                Select::make('period')
                    ->label('Period')
                    ->options([
                        'hours' => 'Hour(s)',
                        'days' => 'Day(s)',
                    ])
                    ->default('days')
                    ->required(),

                Textarea::make('terms')
                    ->columnSpanFull(),
                Section::make('Features')
                    ->schema([
                        Repeater::make('features')
                            ->label('')
                            ->schema([
                                TextInput::make('feature')
                                    ->label("")
                            ])
                            ->columnSpanFull()
                            ->addActionLabel('Add More Feature'),
                            ]),
                Toggle::make('is_recommended')
                    ->label('Recommend Plan?')

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Split::make([
                    TextColumn::make('name'),
                    TextColumn::make('amount')
                        ->hidden(fn ($livewire) => $livewire->activeTab == 'Range'),
                    TextColumn::make('minimum_amount')
                        ->hidden(fn ($livewire) => $livewire->activeTab == 'Fixed'),
                    IconColumn::make('is_unlimited')
                        ->boolean()
                        ->hidden(fn ($livewire) => $livewire->activeTab == 'Fixed'),
                    TextColumn::make('maximum_amount')
                        ->state(fn(Model $record) => $record->maximum_amount_label)
                        ->hidden(fn ($livewire) => $livewire->activeTab == 'Fixed')
                        ,
                    TextColumn::make('interest_rate')
                    ->suffix('%'),
                        // Stack::make([
                        //     TextColumn::make('duration'),
                        //     TextColumn::make('period'),
                        // ]),
                // ])
            
            ])
            ->filters([
                Filter::make('is_unlimited')
                ->label('Show Unlimited')
                ->query(fn (Builder $query) => $query->where('is_unlimited', true))
                ->visible(fn ($livewire) => $livewire->activeTab == 'Range'),
            ], layout: FiltersLayout::Dropdown)
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
            'index' => Pages\ListInvestmentPlans::route('/'),
            'create' => Pages\CreateInvestmentPlan::route('/create'),
            'edit' => Pages\EditInvestmentPlan::route('/{record}/edit'),
        ];
    }
}
