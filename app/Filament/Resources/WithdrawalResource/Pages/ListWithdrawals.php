<?php

namespace App\Filament\Resources\WithdrawalResource\Pages;

use App\Enums\WithdrawalStatus;
use App\Filament\Resources\WithdrawalResource;
use App\Models\Withdrawal;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListWithdrawals extends ListRecords
{
    protected static string $resource = WithdrawalResource::class;

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
                ->badge(Withdrawal::count()),
            'Approved' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', WithdrawalStatus::APPROVED))
                ->badge(Withdrawal::where('status', WithdrawalStatus::APPROVED)->count()),
            'Pending' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', WithdrawalStatus::PENDING))
                ->badge(Withdrawal::where('status', WithdrawalStatus::PENDING)->count()),
            'Declined' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', WithdrawalStatus::DECLINED))
                ->badge(Withdrawal::where('status', WithdrawalStatus::DECLINED)->count()),
        ];
    }
}
