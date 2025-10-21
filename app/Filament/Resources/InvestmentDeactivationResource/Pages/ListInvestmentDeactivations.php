<?php

namespace App\Filament\Resources\InvestmentDeactivationResource\Pages;

use App\Enums\InvestmentDeactivationStatus;
use App\Filament\Resources\InvestmentDeactivationResource;
use App\Models\InvestmentDeactivation;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListInvestmentDeactivations extends ListRecords
{
    protected static string $resource = InvestmentDeactivationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make()
                ->badge(static::$resource::getEloquentQuery()->count()),
            'Pending' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', InvestmentDeactivationStatus::PENDING))
                ->badge(InvestmentDeactivation::where('status', InvestmentDeactivationStatus::PENDING)->count()),
            'Approved' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', InvestmentDeactivationStatus::APPROVED))
                ->badge(InvestmentDeactivation::where('status', InvestmentDeactivationStatus::APPROVED)->count()),
            'Declined' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', InvestmentDeactivationStatus::DECLINED))
                ->badge(InvestmentDeactivation::where('status', InvestmentDeactivationStatus::DECLINED)->count()),
            'Cancelled' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', InvestmentDeactivationStatus::CANCELLED))
                ->badge(InvestmentDeactivation::where('status', InvestmentDeactivationStatus::CANCELLED)->count()),
        ];
    }
}
