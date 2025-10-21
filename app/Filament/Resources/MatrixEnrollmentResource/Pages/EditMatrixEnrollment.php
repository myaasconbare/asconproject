<?php

namespace App\Filament\Resources\MatrixEnrollmentResource\Pages;

use App\Filament\Resources\MatrixEnrollmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMatrixEnrollment extends EditRecord
{
    protected static string $resource = MatrixEnrollmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
