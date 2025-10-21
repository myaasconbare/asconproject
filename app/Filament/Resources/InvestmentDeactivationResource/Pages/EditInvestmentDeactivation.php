<?php

namespace App\Filament\Resources\InvestmentDeactivationResource\Pages;

use App\Filament\Resources\InvestmentDeactivationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInvestmentDeactivation extends EditRecord
{
    protected static string $resource = InvestmentDeactivationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
