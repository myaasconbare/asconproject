<?php

namespace App\Filament\Resources\StakingInvestmentResource\Pages;

use App\Enums\StakingInvestmentStatus;
use App\Filament\Resources\StakingInvestmentResource;
use App\Models\StakingInvestment;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListStakingInvestments extends ListRecords
{
    protected static string $resource = StakingInvestmentResource::class;

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
                ->badge(StakingInvestment::count()),
            
            'Active' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', StakingInvestmentStatus::RUNNING))
                ->badge(StakingInvestment::where('status', StakingInvestmentStatus::RUNNING)->count()),
            'Completed' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', StakingInvestmentStatus::COMPLETED))
                ->badge(StakingInvestment::where('status', StakingInvestmentStatus::COMPLETED)->count()),
        ];
    }
}
