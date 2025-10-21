<?php

namespace App\Filament\Resources\ReferralSettingResource\Pages;

use App\Filament\Resources\ReferralSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReferralSettings extends ListRecords
{
    protected static string $resource = ReferralSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->color('success'),
        ];
    }
}
