<?php

namespace App\Filament\Resources\ReferralRewardResource\Pages;

use App\Filament\Resources\ReferralRewardResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListReferralRewards extends ListRecords
{
    protected static string $resource = ReferralRewardResource::class;

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
