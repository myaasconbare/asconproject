<?php

namespace App\Filament\Resources\RewardBadgeResource\Pages;

use App\Filament\Resources\RewardBadgeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRewardBadges extends ListRecords
{
    protected static string $resource = RewardBadgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->color('success'),
        ];
    }
}
