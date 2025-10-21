<?php

namespace App\Filament\Resources\InvestmentResource\Pages;

use App\Enums\InvestmentStatus;
use App\Filament\Resources\InvestmentResource;
use App\Models\Investment;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListInvestments extends ListRecords
{
    protected static string $resource = InvestmentResource::class;

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
                ->badge(Investment::count()),
            
            'Active' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', InvestmentStatus::ACTIVE))
                ->badge(Investment::where('status', InvestmentStatus::ACTIVE)->count()),
            'Completed' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', InvestmentStatus::COMPLETED))
                ->badge(Investment::where('status', InvestmentStatus::COMPLETED)->count()),
            'Terminated' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', InvestmentStatus::TERMINATED))
                ->badge(Investment::where('status', InvestmentStatus::TERMINATED)->count()),
            'Pending Termination' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', InvestmentStatus::PENDING_TERMINATION))
                ->badge(Investment::where('status', InvestmentStatus::PENDING_TERMINATION)->count()),
        ];
    }
}
