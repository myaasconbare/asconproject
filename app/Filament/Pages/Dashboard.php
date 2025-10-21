<?php

namespace App\Filament\Pages;

use App\Traits\Admin\Notify;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;

class Dashboard extends \Filament\Pages\Dashboard
{
    use Notify;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    // protected static string $view = 'filament.pages.dashboard';

    protected function getHeaderActions(): array
    {
        return [
            Action::make("clear")
                ->label('Clear Cache')
                ->outlined()
                ->color('success')
                ->requiresConfirmation()
                ->action(function (array $data, Action $action): void {
                    
                    Artisan::call("route:clear");
                    Artisan::call("optimize:clear");

                    $this->notify('success', 'Cache cleared successfully');
                }),
                // ->modalWidth('sm'),
        ];
    }
}
