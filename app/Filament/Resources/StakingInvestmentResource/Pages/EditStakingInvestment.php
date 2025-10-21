<?php

namespace App\Filament\Resources\StakingInvestmentResource\Pages;

use App\Filament\Resources\StakingInvestmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStakingInvestment extends EditRecord
{
    protected static string $resource = StakingInvestmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
