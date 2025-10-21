<?php

namespace App\Filament\Resources\PortfolioResource\Widgets;

use App\Filament\Resources\PortfolioResource\Pages\ListPortfolios;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PortfolioStat extends BaseWidget
{
    use InteractsWithPageTable;
    protected static bool $isLazy = false;


    protected function getTablePage(): string
    {
        return ListPortfolios::class;   
    }

    protected function getStats(): array
    {
        $portfolios = $this->getPageTableQuery()->with(['licenses'])->get();

        $stats = [];

        foreach($portfolios as $portfolio){
            array_push(
                $stats, 
                Stat::make($portfolio->name, $portfolio->licenses()->count())
                ->color('success')
                ->description('license(s)')
            );
        }

        return $stats;
    }
}
