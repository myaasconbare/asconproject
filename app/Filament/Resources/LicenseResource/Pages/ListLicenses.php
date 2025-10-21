<?php

namespace App\Filament\Resources\LicenseResource\Pages;

use App\Filament\Resources\LicenseResource;
use App\Models\License;
use App\Models\Setting;
use App\Traits\Admin\Notify;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;

class ListLicenses extends ListRecords
{
    use Notify;

    protected static string $resource = LicenseResource::class;

    public function __construct()
    {
       
    }

    protected function getHeaderActions(): array
    {
        $profitabilityPercentage = Setting::latest()->first()?->profitability_percentage ?? (new Setting)->default_profitablity_percentage;
// 
        // $profitabilityPercentage = $setting->profitability_percentage ?? $setting->default_profitablity_percentage;

        return [
            Actions\CreateAction::make()->color('success'),
            Actions\Action::make('Profitablity Percentage')
                ->label('Profitablity Percentage : ' . $profitabilityPercentage . '%')
                ->outlined()
                ->form([
                    TextInput::make('profitability_percentage')
                        ->required()
                        ->integer()
                        ->minValue(1)
                        ->maxValue(100)
                        ->default($profitabilityPercentage)
                ])
                ->modalWidth('md')
                ->modalHeading('Change Profitablity Percentage')
                ->action(function (array $data) {
                    $setting = Setting::latest()->first();

                    Setting::updateOrCreate(['id' => $setting?->id], ['profitability_percentage' => $data['profitability_percentage']]);

                    return $this->notify('success', 'updated successfully', 'Success');
                }),
        ];
    }
}
