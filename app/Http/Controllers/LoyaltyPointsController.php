<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\IAccountService;
use App\Interfaces\Services\ILoyaltyPointsService;
use App\Models\LoyaltyPointsTransaction;
use Illuminate\Http\Request;

class LoyaltyPointsController extends Controller
{
    public function deposit(
        Request $request,
        ILoyaltyPointsService $loyaltyPointsService,
        IAccountService $accountService
    ): LoyaltyPointsTransaction
    {
        // TODO: add scope to acount and select active account
        $account = $accountService->findByType($request->input('account_type'), $request->input('account_id'));
        return $loyaltyPointsService->depositAndNotify(
            $account,
            $request->only([
                'loyalty_points_rule',
                'description',
                'payment_id',
                'payment_amount',
                'payment_time'
            ])
        );
    }

    public function cancel(Request $request, ILoyaltyPointsService $loyaltyPointsService)
    {
        $loyaltyPointsService->cancelTransaction(
            $request->input('transaction_id'),
            $request->input('cancellation_reason')
        );
    }

    public function withdraw(
        Request $request,
        ILoyaltyPointsService $loyaltyPointsService,
        IAccountService $accountService
    ): LoyaltyPointsTransaction
    {
        $account = $accountService->findByType($request->input('account_type'), $request->input('account_id'));
        return $loyaltyPointsService->withdraw($account, $request->only(['points_amount', 'description']));
    }
}
