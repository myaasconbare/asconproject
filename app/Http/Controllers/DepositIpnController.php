<?php

namespace App\Http\Controllers;

use App\Enums\DepositStatus;
use App\Models\Deposit;
use App\Services\DepositService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DepositIpnController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        try {

            $status = $request->input('payment_status');
            $transactionId = $request->input('order_id');
            $senderWalletAddress = $request->input('pay_address');

            $depositStatus = match ($status) {
                'waiting' => DepositStatus::PENDING,
                'confirming', 'confirmed', 'sending' => DepositStatus::PROCESSING,
                'failed', 'refunded', 'expired' => DepositStatus::DECLINED,
                'finished', 'partially_paid' => DepositStatus::APPROVED,
                default => DepositStatus::PENDING,
            };

            $deposit = Deposit::where('transaction_id', $transactionId)->first();

            if (!$deposit) return;

            if ($depositStatus->value == DepositStatus::APPROVED->value) {
                $depositService = resolve(DepositService::class);

                Log::info('params-received', $request->input());

                $depositService->approve($deposit->id, $senderWalletAddress, $request->input('actually_paid'));

                Log::info("{$deposit->user->username} Deposit approved successfully");
                return ['Deposit approved successfully'];
            } else {
                $deposit->update(['status' => $depositStatus->value]);
                Log::info("{$deposit->user->username} Deposit status set to {$deposit->status}");

                return ["{$deposit->user->username} Deposit status set to {$deposit->status}"];
            }
        } catch (\Exception $e) {
            Log::error('Deposit-error', [$deposit, 'message' => $e->getMessage()]);
        }
    }
}
