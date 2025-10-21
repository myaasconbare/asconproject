<?php

namespace App\Filament\Resources\InvestmentPlanResource\Pages;

use App\Filament\Resources\InvestmentPlanResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListInvestmentPlans extends ListRecords
{
    protected static string $resource = InvestmentPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->color('success'),
        ];
    }

    public function getTabs(): array
{
    return [
        'Range' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('is_fixed', false)),
        'Fixed' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('is_fixed', true)),
    ];
}
}
