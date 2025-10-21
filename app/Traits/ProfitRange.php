<?php

namespace App\Traits;

use App\Models\License;
use App\Models\Portfolio;
use Illuminate\Support\Number;
use Livewire\Attributes\Computed;

trait ProfitRange
{
    public function getRange($portfolio)
    {
        $licenses = $portfolio->licenses->sortBy('minimum_amount');

        $minimumAmount = $licenses->first()->minimum_amount;

        $maximumLicense = $licenses->last();

        return [
            'label' => Number::currency($minimumAmount) . '-' . $maximumLicense->maximum_amount_format,
            'minimum_amount' => $minimumAmount,
            'maximum_amount' => $maximumLicense->maximum_amount,
            'is_unlimited' => $maximumLicense->is_unlimited,
            'maximum_amount_label' => $maximumLicense->maximum_amount_format,
        ];
    }

    #[Computed]
    public function portfolios()
    {
        return Portfolio::with('licenses:id,portfolio_id,minimum_amount,maximum_amount,minimum_interest_rate,maximum_interest_rate,is_unlimited')
            ->where('is_active', true)
            ->get(['id', 'duration', 'period', 'name']);
    }

    #[Computed]
    public function licenses()
    {
        return License::with(["portfolio:id,duration,period,name"])
            ->orderBy('minimum_amount')
            ->get();
    }
}
