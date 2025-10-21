<?php

namespace App\Filament\Resources\PortfolioResource\Pages;

use App\Filament\Resources\PortfolioResource;
use App\Filament\Resources\PortfolioResource\Widgets\PortfolioStat;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListPortfolios extends ListRecords
{
    use ExposesTableToWidgets;
    
    protected static string $resource = PortfolioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->color('success'),
                // ->modalWidth('md'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PortfolioStat::class
        ];
    }
}
