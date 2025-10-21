<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\FormattedDate;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasUuids, FormattedDate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $autoIncrement = false;

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function transaction(): MorphMany {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

    public function verificationTokens() : HasMany {
        return $this->hasMany(VerificationToken::class);
    }

    public function verificationToken() : HasMany {
        return $this->verificationTokens()->latest()->one();
    }

    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referrer_user_id');
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class, 'user_id');
    }


    public function teamRewards(): HasMany
    {
        return $this->hasMany(TeamReward::class, 'user_id');
    }

    public function teamReward(): HasOne
    {
        return $this->teamRewards()->latest()->one();
    }

    public function investments(): HasMany
    {
        return $this->hasMany(Investment::class, 'user_id');
    }

    public function rechargePins(): HasMany
    {
        return $this->hasMany(RechargePin::class, 'user_id');
    }

    public function profits(): HasMany
    {
        return $this->hasMany(Profit::class, 'user_id');
    }

    public function investmentDeactivations(): HasMany
    {
        return $this->hasMany(InvestmentDeactivation::class, 'user_id');
    }

    public function deposits(): HasMany
    {
        return $this->hasMany(Deposit::class, 'user_id');
    }

    public function withdrawals(): HasMany
    {
        return $this->hasMany(Withdrawal::class, 'user_id');
    }

    public function trades(): HasMany
    {
        return $this->hasMany(Trade::class, 'user_id');
    }

    public function stakingInvestments(): HasMany
    {
        return $this->hasMany(StakingInvestment::class, 'user_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class, 'user_id');
    }

    public function rewardBadgeHistory(): HasMany
    {
        return $this->hasMany(RewardBadgeHistory::class, 'user_id');
    }

    public function referralsWithLimit(): HasMany
    {
        return $this->referrals()->where('level', '<=', referralLevel());
    }

    public function directReferrals(): HasMany
    {
        return $this->referrals()->where('level', 1);
    }


    public function getReferralCountWithLimitAttribute()
    {
        $referralsCount = $this->referralsWithLimit()->count();
        $limit = referralLevel();
        return $referralsCount > $limit ? $limit : $referralsCount;
    }

    public function getFullnameAttribute()
    {
        return $this->lastname . ' ' . $this->firstname;
    }

    public function getReferralUrlAttribute()
    {
        return route('guest.home', ['reference' => Auth::id()]);
    }

    public function rewardBadge(): BelongsTo
    {
        return $this->belongsTo(RewardBadge::class, 'reward_badge_id')
            ->withDefault(fn() => new RewardBadge(['name' => 'N/A']));
    }

    public function metBadgeCriteria($badge)
    {
        $passedMinimumDeposit = $this->total_deposited >= $badge->minimum_deposit;
        $passedMinimumTeamInvest = $this->total_team_volume >= $badge->minimum_team_invest;
        $passedMinimumInvest = $this->total_invested >= $badge->minimum_invest;
        $passedMinimumReferrals = $this->total_direct_referrals >= $badge->minimum_referral_count;

        return $passedMinimumDeposit && 
            $passedMinimumTeamInvest && 
            $passedMinimumInvest &&
            $passedMinimumReferrals;
    }


    public function getComputedRewardBadgeAttribute()
    {
        $badges = RewardBadge::orderBy('reward')->get();

        $leastBadge = $badges->first();

        if (!$this->metBadgeCriteria($leastBadge)) return null;

        $badge = null;

        for ($i = 0; $i < count($badges); $i++) {
            $currentBadge = $badges[$i];
            $nextBadge = $badges->get($i + 1);

            if (!$nextBadge) {
                $badge = $currentBadge;
                break;
            }

            $passedCurrentBadge = $this->metBadgeCriteria($currentBadge);

            $passedNextBadge = $this->metBadgeCriteria($nextBadge);

            if (!$passedCurrentBadge || !$passedNextBadge) {
                $badge = $currentBadge;
                break;
            }

            if ($passedNextBadge) continue;

            $badge = $currentBadge;
        }

        return $badge;
    }

    public function matrixEnrollments(): HasMany
    {
        return $this->hasMany(MatrixEnrollment::class, 'user_id');
    }
    public function getHasMatrixPlanAttribute()
    {
        return $this->matrixEnrollments()->count();
    }
    public function scopeActive(): User
    {
        return Auth::user();
    }

    public function scopeGetMonthRecord($query, $relation, $date, $status = null)
    {
        return $this->{$relation}()
            ->when('status', fn($query) => $query->where('status', $status))
            // ->where('status', $status)
            ->whereYear('created_at', $date->format('Y'))
            ->whereMonth('created_at', $date->format('m'));
    }
    public function getAvatarUrlAttribute()
    {
        return $this->image ? $this->image_url : "https://ui-avatars.com/api/?name={$this->email}";
    }

    public function getImageUrlAttribute()
    {
        return asset('uploads/' . $this->image);
    }
}
