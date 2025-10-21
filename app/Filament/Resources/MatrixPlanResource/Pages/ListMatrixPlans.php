<?php

namespace App\Filament\Resources\MatrixPlanResource\Pages;

use App\Filament\Resources\MatrixPlanResource;
// use App\Models\MatrixSetting;
use App\Services\MatrixService;
use App\Traits\Admin\Notify;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;

class ListMatrixPlans extends ListRecords
{
    use Notify;

    protected static string $resource = MatrixPlanResource::class;

    protected function getHeaderActions(): array
    {
        $matrixService = resolve(MatrixService::class);
        $matrixSetting = $matrixService->getMatrixSettings();

        // dd($matrixSetting);
        
        return [
            Actions\CreateAction::make()->color('success'),
            Actions\Action::make('Matrix Settings')
                ->button()
                ->outlined()
                ->color('success')
                ->form(function() use($matrixSetting) {
                    return [
                        TextInput::make('height')
                            ->required()
                            ->default($matrixSetting?->height),
                        TextInput::make('width')
                            ->required()
                            ->default($matrixSetting?->width),
                    ];
                })
                ->action(function(array $data) use($matrixService) {
                    $response = $matrixService->updateMatrixSettings($data);
                    $this->notify($response['type'], $response['message']);
                })
                ->modalWidth('md')
                ->modalHeading('Matrix Parameters Update')
                ->modalSubmitActionLabel('Update'),
        ];
    }
}
