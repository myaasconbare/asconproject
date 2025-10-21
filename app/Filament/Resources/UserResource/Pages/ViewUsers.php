<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\RawJs;

class ViewUsers extends ViewRecord
{
    protected static string $resource = UserResource::class;

    // protected static string $view = 'filament.resources.user-resource.pages.view-users';


    protected static string $view = 'filament.resources.user-resource.pages.view-users';

    public array $balanceData = [
        'deposit_wallet',
        'interest_wallet',
        'residual_wallet',
    ];




    // public static function getNavigationItems(array $urlParameters = []): array
    // {
    //     return [];
    // }


    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        

        $this->balanceData = [
            'deposit_wallet' => $this->record->deposit_wallet,
            'interest_wallet' => $this->record->interest_wallet,
            'residual_wallet' => $this->record->residual_wallet,
        ];
    }

    protected function getForms(): array
    {
        return [
            'balanceForm',
            // 'referralForm',
        ];
    }

    public function getBalanceForm()
    {
        return [
            TextInput::make('deposit_wallet')
                ->placeholder('Enter volume')
                ->prefix('$')
                ->mask(RawJs::make('$money($input)'))
                ->stripCharacters(',')
                ->numeric()
                ->columnSpan(1)
                ->required(),
            TextInput::make('interest_wallet')
                ->placeholder('Enter reward')
                ->prefix('$')
                ->mask(RawJs::make('$money($input)'))
                ->stripCharacters(',')
                ->numeric()
                ->columnSpan(1)
                ->required(),
            TextInput::make('residual_wallet')
                ->placeholder('Enter reward')
                ->prefix('$')
                ->mask(RawJs::make('$money($input)'))
                ->stripCharacters(',')
                ->numeric()
                ->columnSpan(1)
                ->required()
                ,
            
        ];
    }


    public function balanceForm(Form $form): Form
    {
        return $form
            ->schema($this->getBalanceForm())
            ->statePath('balanceData');
    }


    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('name'),
 
                TextEntry::make('email')
            ])
            ->record($this->record);
    }
}
