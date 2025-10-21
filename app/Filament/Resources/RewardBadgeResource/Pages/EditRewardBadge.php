<?php

namespace App\Filament\Resources\RewardBadgeResource\Pages;

use App\Filament\Resources\RewardBadgeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRewardBadge extends EditRecord
{
    protected static string $resource = RewardBadgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
