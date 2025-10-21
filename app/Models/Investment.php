<?php

namespace App\Models;

use App\Enums\InvestmentStatus;
use App\Traits\UseSearch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Investment extends Model
{
    use UseSearch;

    protected $guarded = [];

    protected $casts = [
        'last_payment' => 'datetime',
        'upcoming_payment' => 'datetime',
    ];

    public function deactivations(): HasMany
    {
        return $this->hasMany(InvestmentDeactivation::class)->latest();
    }

    public function transaction(): MorphOne
    {
        return $this->MorphOne(Transaction::class, 'transactionable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function profits(): HasMany
    {
        return $this->hasMany(Profit::class);
    }

    public function license(): BelongsTo
    {
        return $this->belongsTo(License::class, 'license_id');
    }

    public function scopebyActiveUser($query)
    {
        return $query->where('user_id', Auth::id());
    }

    public function getLastPayment()
    {
        return $this->last_payment ? $this->last_payment->addMinute() : $this->created_at->addMinute();
    }
    public function getNextPayment()
    {
        return $this->getLastPayment()->copy()->addMinute();
    }
    

    public function scopeActive($query)
    {
        return $query->where('status', InvestmentStatus::ACTIVE);
    }

    public function scopePendingDeactivation($query)
    {
        return $query->where('status', InvestmentStatus::PENDING_TERMINATION);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', InvestmentStatus::COMPLETED);
    }

    public function getActiveInterestRateAttribute()
    {
        $license = $this->license;

        $license->minimum_interest_rate = $this->minimum_interest_rate ?? $license->minimum_interest_rate;
        $license->maximum_interest_rate = $this->maximum_interest_rate ?? $license->maxiimum_interest_rate;

        return $license->getRateAttribute($this->profitability_percentage);
    }

    public function getStatusLabelAttribute(){
        return Str::headline($this->status);
    }

    public function getStatusColorAttribute(){
        return match($this->status){
            InvestmentStatus::ACTIVE->value => "info",
            InvestmentStatus::COMPLETED->value => "success",
            InvestmentStatus::TERMINATED->value => "danger",
            InvestmentStatus::PENDING_TERMINATION->value => "primary",
            default => 'info border badge-info'
        };
    }

}
