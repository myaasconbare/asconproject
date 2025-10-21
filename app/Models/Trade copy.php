<?php

namespace App\Models;

use App\Enums\TradeOutcome;
use App\Enums\TradeStatus;
use App\Enums\TradeVolume;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class TradeCopy extends Model
{
    protected $guarded = [];

    protected $casts = [
        'arrival_time' => 'datetime'
    ];
    
    public function transaction(): MorphOne {
        return $this->MorphOne(Transaction::class, 'transactionable');
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cryptoCurrency() : BelongsTo {
        return $this->belongsTo(CryptoCurrency::class, 'crypto_currency_id');
    }

    public function getVolumeLabelAttribute(){
        return TradeVolume::from($this->volume)->name;
    }

    public function getStatusColorAttribute(){
        return match($this->status){
            TradeStatus::COMPLETE->value => "success",
            TradeStatus::RUNNING->value => "primary",
        };
    }

    public function getOutcomeColorAttribute(){
        return match($this->outcome){
            TradeOutcome::INITIATED->value => "primary",
            TradeOutcome::WIN->value => "success",
            TradeOutcome::LOSE->value => "danger",
            default => 'info'
        };
    }

    public function getAmountColorAttribute(){
        return match($this->outcome){
            TradeOutcome::INITIATED->value => "white",
            TradeOutcome::WIN->value => "success",
            TradeOutcome::LOSE->value => "danger",
            TradeOutcome::DRAW->value => "primary",

            default => 'info border badge-info'
        };
    }

    public function scopeToday($query){
        return $this->onDate(Carbon::today());
    }
    public function scopeOnDate($query, $date){
        return $query->where('created_at', $date);
    }
    public function scopeHighRecords($query){
        return $query->where('volume', TradeVolume::HIGH);
    }
    public function scopeLowRecords($query){
        return $query->where('volume', TradeVolume::LOW);
    }
    public function scopeWinRecords($query){
        return $query->where('outcome', TradeOutcome::WIN);
    }
    public function scopeLossRecords($query){
        return $query->where('outcome', TradeOutcome::LOSE);
    }
    public function scopeDrawRecords($query){
        return $query->where('outcome', TradeOutcome::DRAW);
    }
}
