<?php

namespace App\Filament\Resources\CryptoCurrencyResource\Pages;

use App\Filament\Resources\CryptoCurrencyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCryptoCurrency extends EditRecord
{
    protected static string $resource = CryptoCurrencyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
