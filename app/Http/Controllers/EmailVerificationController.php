<?php

namespace App\Http\Controllers;

use App\Enums\AdminNotificationTypes;
use App\Filament\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        $request->fulfill();

        $user = activeUser();

        if ($user->referrer) {
            resolve(UserService::class)->updateReferralTree($user);
        }

        $userService = resolve(UserService::class);

        $userService->notifyAdminViaDashboard(
            type: AdminNotificationTypes::NEW_USER->value,
            body: AdminNotificationTypes::message(AdminNotificationTypes::NEW_USER->value, ['%user' => $user->email]),
            url: UserResource::getUrl('index', ['tableSearch' => $user->email])
        );

        return to_route('user.dashboard');
    }

    // public function authorize(Request $request)
    // {
    //     if (! hash_equals((string) $request->user()->getKey(), (string) $request->route('id'))) {
    //         return false;
    //     }

    //     if (! hash_equals(sha1($request->user()->getEmailForVerification()), (string) $request->route('hash'))) {
    //         return false;
    //     }

    //     return true;
    // }
}
