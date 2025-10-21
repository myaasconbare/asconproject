<?php

namespace App\Models;

use App\Traits\FormattedDate;
use App\Traits\UseSearch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Auth;

class Deposit extends Model
{
    use FormattedDate, UseSearch;
    
    protected $guarded = [];

    public function transaction(): MorphOne {
        return $this->MorphOne(Transaction::class, 'transactionable');
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopebyActiveUser($query){
        return $query->where('user_id', Auth::id());
    }

    public function getCurrencyLabelAttribute(){
        if(!$this->network || $this->currency == $this->network) return $this->currency;

        return match(strtolower($this->currency)){
            'usdterc20' => 'usdt (ERC20)',
            'usdttrc20' => 'usdt (TRC20)',
            default => $this->currency
        };
    }
}
