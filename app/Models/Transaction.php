<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Enums\Transaction as TransactionEnum;
use App\Enums\Transaction\WalletType;
use App\Traits\FormattedDate;
use App\Traits\UseSearch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

use function Filament\Support\get_model_label;
use function Pest\Laravel\get;

class Transaction extends Model
{
    use FormattedDate, UseSearch;

    protected $guarded = [];

    // protected $casts = [
    //     'meta' => 'array',
    // ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function transactionable(): MorphTo
    {
        return $this->morphTo();
    }

    // public function getPostBalanceLabelAttribute(){
    //     $postBalance = Number::currency($this->post_balance);
    //     return match(get_class($this->transactionable)){
    //         default => "Deposit Wallet : " . $postBalance,
    //     };
    // }

    public function getStatusColorAttribute()
    {
        return match ($this->transactionable->status) {
            TransactionEnum\Status::PENDING->value => "bg-warning",
            TransactionEnum\Status::COMPLETED->value => "bg-success",
            TransactionEnum\Status::APPROVED->value => "bg-success",
            TransactionEnum\Status::PROCESSING->value => "bg-info",
            TransactionEnum\Status::DECLINED->value => "bg-danger",
            default => "bg-primary",
        };
    }
    public function getPostBalanceLabelAttribute()
    {
        $postBalance = Number::currency($this->post_balance);

        return "$this->wallet_type_label : " . $postBalance;
    }

    public function getWalletTypeLabelAttribute()
    {
        return Str::headline($this->wallet_type);
    }

    public function scopewithoutDeleted(Builder $query)
    {
        return $query->whereHas(
            "transactionable",
            fn($query) => Schema::hasColumn(
                $query->getModel()->getTable(),
                "deleted_at"
            ) && $query->whereNull("deleted_at")
        );
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function (Model $record) {
            $transaction_id = transactionId();
            $record->transaction_id = $transaction_id;
        });
    }
}
