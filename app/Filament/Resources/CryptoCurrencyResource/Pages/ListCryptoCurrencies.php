<?php

namespace App\Filament\Resources\CryptoCurrencyResource\Pages;

use App\Filament\Resources\CryptoCurrencyResource;
use App\Models\CryptoCurrency;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListCryptoCurrencies extends ListRecords
{
    protected static string $resource = CryptoCurrencyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make()->color('success'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make()
                ->badge(CryptoCurrency::count()),
            'Active' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', true))
                ->badge(CryptoCurrency::where('is_active', true)->count()),
            'Inactive' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', false))
                ->badge(CryptoCurrency::where('is_active', false)->count()),
        ];
    }
}
