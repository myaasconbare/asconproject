<?php

namespace App\Filament\Resources\TradeDurationResource\Pages;

use App\Filament\Resources\TradeDurationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTradeDuration extends EditRecord
{
    protected static string $resource = TradeDurationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
