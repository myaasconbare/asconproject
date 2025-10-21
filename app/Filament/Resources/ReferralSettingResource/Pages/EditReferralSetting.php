<?php

namespace App\Filament\Resources\ReferralSettingResource\Pages;

use App\Filament\Resources\ReferralSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReferralSetting extends EditRecord
{
    protected static string $resource = ReferralSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
