<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\CancelRequest;
use App\Http\Requests\Transaction\DepositRequest;
use App\Http\Requests\Transaction\WithdrawRequest;
use App\Interfaces\Services\IAccountService;
use App\Interfaces\Services\ILoyaltyPointsService;
use App\Models\LoyaltyPointsTransaction;

class LoyaltyPointsController extends Controller
{
    public function deposit(
        DepositRequest $request,
        ILoyaltyPointsService $loyaltyPointsService,
        IAccountService $accountService
    ): LoyaltyPointsTransaction
    {
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

    public function cancel(CancelRequest $request, ILoyaltyPointsService $loyaltyPointsService)
    {
        $loyaltyPointsService->cancelTransaction(
            $request->input('transaction_id'),
            $request->input('cancellation_reason')
        );
    }

    public function withdraw(
        WithdrawRequest $request,
        ILoyaltyPointsService $loyaltyPointsService,
        IAccountService $accountService
    ): LoyaltyPointsTransaction
    {
        $account = $accountService->findByType($request->input('account_type'), $request->input('account_id'));
        return $loyaltyPointsService->withdraw($account, $request->only(['points_amount', 'description']));
    }
}
