<?php

namespace App\Filament\Resources\TradeResource\Pages;

use App\Enums\TradeOutcome;
use App\Filament\Resources\TradeResource;
use App\Models\Trade;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListTrades extends ListRecords
{
    protected static string $resource = TradeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make()->color('success'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make()
                ->badge(Trade::count()),
            
            'Win' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('deleted_at')->where('outcome', TradeOutcome::WIN))
                ->badge(Trade::whereNull('deleted_at')->where('outcome', TradeOutcome::WIN)->count()),
            'Lose' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('deleted_at')->where('outcome', TradeOutcome::LOSE))
                ->badge(Trade::whereNull('deleted_at')->where('outcome', TradeOutcome::LOSE)->count()),
            'Draw' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('deleted_at')->where('outcome', TradeOutcome::DRAW))
                ->badge(Trade::whereNull('deleted_at')->where('outcome', TradeOutcome::DRAW)->count()),
            'Initiated' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('deleted_at')->where('outcome', TradeOutcome::INITIATED))
                ->badge(Trade::whereNull('deleted_at')->where('outcome', TradeOutcome::INITIATED)->count()),
        ];
    }
}
