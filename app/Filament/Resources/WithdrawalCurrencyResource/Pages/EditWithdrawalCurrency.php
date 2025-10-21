<?php

namespace App\Filament\Resources\WithdrawalCurrencyResource\Pages;

use App\Filament\Resources\WithdrawalCurrencyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWithdrawalCurrency extends EditRecord
{
    protected static string $resource = WithdrawalCurrencyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
