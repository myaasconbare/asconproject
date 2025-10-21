<?php

namespace App\Filament\Resources\MatrixPlanResource\Pages;

use App\Filament\Resources\MatrixPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMatrixPlan extends EditRecord
{
    protected static string $resource = MatrixPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
