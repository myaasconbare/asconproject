<?php

namespace App\Filament\Resources\WithdrawalCurrencyResource\Pages;

use App\Filament\Resources\WithdrawalCurrencyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWithdrawalCurrencies extends ListRecords
{
    protected static string $resource = WithdrawalCurrencyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->color('success'),
        ];
    }
}
