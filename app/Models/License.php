<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;

class License extends Model
{
    protected $guarded = [];

    protected $casts = [
        'features' => 'array'
    ];


    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }

    public function getMaximumAmountLabelAttribute()
    {
        return $this->is_unlimited ? 'UNLIMITED' : $this->maximum_amount;
    }
    public function getMaximumAmountFormatAttribute()
    {
        return $this->is_unlimited ? 'UNLIMITED' : Number::currency($this->maximum_amount);
    }
    public function getNameAttribute()
    {
        return $this->portfolio->name . ' : ' . $this->minimum_amount_format . ' - ' . $this->maximum_amount_format;
    }

    public function getMinimumAmountFormatAttribute()
    {
        return Number::currency($this->minimum_amount);
    }

    public function getEndTime()
    {
        return now()->{'add' . $this->portfolio->period}($this->portfolio->duration);
    }

    public function getPeriodLabelAttribute()
    {
        $this->period = ucfirst($this->period);

        if ($this->duration > 1) return $this->period;

        return  substr($this->period, 0, strlen($this->period) - 1);
    }

    public function getFeaturesTrimAttribute()
    {
        return array_filter($this->features[0], function ($feature) {
            return trim($feature);
        });
    }

    public function getRateAttribute($profitabilityPercentage = null)
    {

        $setting = Setting::latest()->first();
        $profitabilityPercentage = $profitabilityPercentage ?? ($setting?->profitability_percentage ?? (new Setting)->default_profitablity_percentage);

        $rangeLower = $this->minimum_interest_rate;
        $rangeUpper = $this->maximum_interest_rate;

        $rangeLen = range($rangeLower, $rangeUpper, 0.01);


        $rateIndex = ($profitabilityPercentage / 100) * count($rangeLen);


        return $rangeLen[$rateIndex - 1];
    }

    public function getUpComingPaymentAttribute()
    {
        return now()->{'add' . $this->period}($this->duration);
    }
}
