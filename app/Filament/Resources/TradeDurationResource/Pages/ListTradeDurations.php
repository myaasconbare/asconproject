<?php

namespace App\Filament\Resources\TradeDurationResource\Pages;

use App\Filament\Resources\TradeDurationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTradeDurations extends ListRecords
{
    protected static string $resource = TradeDurationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->color('success')
                ->modalWidth('md'),
        ];
    }
}
