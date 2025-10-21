<?php

namespace App\Filament\Resources\DepositResource\Pages;

use App\Enums\DepositStatus;
use App\Filament\Resources\DepositResource;
use App\Models\Deposit;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListDeposits extends ListRecords
{
    protected static string $resource = DepositResource::class;

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
                ->badge(Deposit::count()),
            
            'Approved' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('deleted_at')->where('status', DepositStatus::APPROVED))
                ->badge(Deposit::whereNull('deleted_at')->where('status', DepositStatus::APPROVED)->count()),
            'Processing' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('deleted_at')->where('status', DepositStatus::PROCESSING))
                ->badge(Deposit::whereNull('deleted_at')->where('status', DepositStatus::PROCESSING)->count()),
            'Pending' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('deleted_at')->where('status', DepositStatus::PENDING))
                ->badge(Deposit::whereNull('deleted_at')->where('status', DepositStatus::PENDING)->count()),
            'Declined' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('deleted_at')->where('status', DepositStatus::DECLINED))
                ->badge(Deposit::whereNull('deleted_at')->where('status', DepositStatus::DECLINED)->count()),
        ];
    }
}
