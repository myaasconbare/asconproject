<?php

namespace App\Services;

use App\Enums\AdminNotificationTypes;
use App\Filament\Resources\UserResource;
use App\Models\User;
use App\Notifications\User\Verification;
use App\Traits\NotifyAdmin;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use App\Enums\Transaction;
use App\Enums\Transaction\WalletType;
use App\Models\VerificationToken;
use App\Notifications\User\ResetPassword;
use Error;
use Illuminate\Support\Number;
use Throwable;
use Illuminate\Support\Str;

class UserService
{
    use NotifyAdmin;

    public function __construct()
    {
        //
    }

    public function loginAsUser($user, $referrerPage)
    {
        auth('web')->login($user);

        session()->put('view_details', [
            'referrer_page' => $referrerPage,
            'user_id' => auth('web')->id(),
            'admin_id' => auth('admin')->id(),
        ]);

        session(['two_factor_verified' => true]);

        to_route('user.dashboard');
    }

    public function topup($user, $wallet, $amount)
    {
        try {
            DB::transaction(function () use (&$account, $user, $wallet, $amount) {


                $preBalance = $user->{$wallet};

                $user->{$wallet} = (float) $user->{$wallet} + (float) $amount;

                $user->save();

                $account = match ($wallet) {
                    'trade_practice_wallet' => 'Practice Balance'
                };

                $user->transaction()->create([
                    'user_id' => $user->id,
                    'amount' => $amount,
                    'pre_balance' => $preBalance,
                    'post_balance' => $user->{$wallet},
                    'type' => Transaction\Type::PLUS,
                    'source' => Transaction\Source::TRADE,
                    'wallet_type' => WalletType::from($account),
                    'details' => "Topped Up $account with " . Number::currency($amount),
                ]);
            });
        } catch (Throwable $e) {
            Log::info('unable to top up account', ['messsage' => $e->getMessage()]);
            throw new Error("Unable to top up" . $account);
        }
    }

    public function login($user, $rememberMe = false)
    {
        auth('web')->login($user, $rememberMe);

        session(['user_id' => Auth::id()]);

        $this->notifyAdminViaDashboard(
            type: AdminNotificationTypes::NEW_LOGIN->value,
            body: AdminNotificationTypes::message(AdminNotificationTypes::NEW_LOGIN->value, ['%user' => $user->email]),
            url: UserResource::getUrl('index', ['tableSearch' => $user->email])
        );

        return redirect()->intended(route('user.dashboard', absolute: false));
    }


    public function updateReferralTree($user)
    {
        $level = 1;

        $referrer = $user->referrer;

        $referrer->increment('total_direct_referrals');

        do {

            Log::info(['referrer' => $referrer->username]);

            $referrer->referrals()->create([
                'referred_user_id' => $user->id,
                'level' => $level
            ]);

            $referrer->increment('total_referrals');

            $referrer = User::find($referrer->referrer_user_id);

            $level++;
        } while ($referrer);

        $user->update(['referral_level' => $level - 1]);
    }

    public function create(array $details): User
    {
        try {

            DB::transaction(function () use ($details,  &$user) {
                $user = User::with(['referrer'])->create($details);

                // if ($user->referrer) {
                //     $this->updateReferralTree($user);
                // }

                $this->sendVerification($user);
            });

            Log::info('account created successfully', ['details' => $details]);

            return $user;
        } catch (Throwable $e) {
            Log::error('unable to create account', ['message' => $e->getMessage(), 'details' => $details]);

            throw new Error("Something went wrong while creating account. Please try again later. Contact support if issue persists");
        }
    }

    public function sendVerification(User $user)
    {

        $url = URL::temporarySignedRoute(
            'auth.verification',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );

        $user->notify(new Verification($url));
        // $user->sendEmailVerificationNotification();
    }

    public function sendPasswordVerification(User $user)
    {
        $expiryTime = Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60));

        $token = $user->verificationTokens()->updateOrCreate(['user_id' => $user->id], [
            'code' => Str::orderedUuid(),
            'expires_at' => $expiryTime,
            'is_expired' => false,
        ]);

        $url = URL::temporarySignedRoute(
            'auth.reset-password',
            $expiryTime,
            [
                'token' => $token->code,
                'hash' => sha1($user->email),
                'test' => $token->code,
            ]
        );

        $user->notify(new ResetPassword($url));
    }

    public function updatePassword($user, $details)
    {
        $user->update(['password' => Hash::make($details['password'])]);

        $user->refresh();
    }

    public function updateProfileInfo($user, $details)
    {
        $user->update([
            "firstname" => $details["firstname"],
            "lastname" => $details["lastname"],
            "phone" => $details["phone"],
            "email" => $details["email"],
            "address" => $details["address"],
            "country" => $details["country"],
            "city" => $details["city"],
            "postcode" => $details["postcode"],
            "state" => $details["state"],
        ]);

        $user->refresh();
    }
    public function isValid2FACode(array $details)
    {
        $user = User::findOrFail($details['user_id']);

        $google_2fa_secret = in_array('2fa_secret', array_keys($details)) ? $details['2fa_secret'] : $user->{'2fa_secret'};

        // dd($google_2fa_secret);


        $google2fa = app('pragmarx.google2fa');

        $secret = trim(str_replace(' ', '', $details['code']));

        return $google2fa->verifyKey($google_2fa_secret, $secret);
    }
}
