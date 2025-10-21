<?php

namespace App\Filament\Resources\ReferralSettingResource\Pages;

use App\Filament\Resources\ReferralSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewReferralSetting extends ViewRecord
{
    protected static string $resource = ReferralSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
