<?php

namespace App\Filament\Resources\MatrixEnrollmentResource\Pages;

use App\Filament\Resources\MatrixEnrollmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMatrixEnrollments extends ListRecords
{
    protected static string $resource = MatrixEnrollmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make()->color('success'),
        ];
    }
}
