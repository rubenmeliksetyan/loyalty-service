<?php

namespace App\Services;

use App\Events\LoyaltyPointsReceived;
use App\Interfaces\Services\IAccountService;
use App\Interfaces\Services\ILoyaltyPointsService;
use App\Models\LoyaltyAccount;
use App\Models\LoyaltyPointsRule;
use App\Models\LoyaltyPointsTransaction;
use App\Strategies\AbsolutePointsAmountCalculationStrategy;
use App\Strategies\Contexts\CalculationStrategyContext;
use App\Strategies\NoRuleCalculationStrategy;
use App\Strategies\Parameters\CalculationStrategyParameters;
use App\Strategies\RelativeRateCalculationStrategy;
use App\Strategies\WithdrawAmountCalculationStrategy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LoyaltyPointsService implements ILoyaltyPointsService
{

    private IAccountService $accountService;

    public function __construct(IAccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function depositAndNotify(LoyaltyAccount $account, array $paymentAttributes): LoyaltyPointsTransaction
    {
        Log::info('Deposit transaction input:', ['attributes' => $paymentAttributes]);
        $pointsRule = LoyaltyPointsRule::where('points_rule', $paymentAttributes['loyalty_points_rule'] ?? '')->first();

        $amount = $this->calculateDepositAmount($paymentAttributes['payment_amount'], $pointsRule);

        $transaction = LoyaltyPointsTransaction::create([
            'account_id' => $account->id,
            'points_rule' => $pointsRule?->id,
            'points_amount' => $amount,
            'description' => $paymentAttributes['description'],
            'payment_id' => $paymentAttributes['payment_id'],
            'payment_amount' => $paymentAttributes['payment_amount'],
            'payment_time' => $paymentAttributes['payment_time'],
        ]);
        Log::info('transaction is created', ['transaction' => $transaction]);
        event(new LoyaltyPointsReceived($account, $transaction));

        return $transaction;
    }

    public function cancelTransaction(int $transactionId, $reason): void
    {
        $transaction = $this->findTransactionById($transactionId);
        $transaction->canceled = Carbon::now();
        $transaction->cancellation_reason = $reason;
        $transaction->save();
    }

    public function withdraw(LoyaltyAccount $account, array $withdrawAttributes): LoyaltyPointsTransaction
    {
        Log::info('Withdraw loyalty points transaction input: ', ['WithdrawAttributes' => $withdrawAttributes]);
        $balance = $this->accountService->getBalance('email', $account->email);
        if ($balance < $withdrawAttributes['points_amount']) {
            Log::info('Wrong loyalty points amount: ', ['points_amount' => $withdrawAttributes['points_amount']]);
             throw new \InvalidArgumentException("Insufficient funds: " . $withdrawAttributes['points_amount']);
        }
        $amount = $this->getWithdrawAmount($withdrawAttributes['points_amount']);
        $transaction = LoyaltyPointsTransaction::create([
            'account_id' => $account->id,
            'points_rule' => LoyaltyPointsRule::WITHDRAW,
            'points_amount' => $amount,
            'description' => $withdrawAttributes['description'],
        ]);
        Log::info('transaction created', ['transaction' => $transaction]);
        return $transaction;
    }

    private function calculateDepositAmount(float $amount, LoyaltyPointsRule $rule = null): float {
        $context = new CalculationStrategyContext();
        $parameters = new CalculationStrategyParameters();

        switch ($rule?->accrual_type) {
            case LoyaltyPointsRule::ACCRUAL_TYPE_RELATIVE_RATE:
                $parameters->setAmount($amount);
                $parameters->setPaymentRule($rule);
                $context->setStrategy(new RelativeRateCalculationStrategy($parameters));
                break;
            case LoyaltyPointsRule::ACCRUAL_TYPE_ABSOLUTE_POINTS_AMOUNT:
                $parameters->setPaymentRule($rule);
                $context->setStrategy(new AbsolutePointsAmountCalculationStrategy($parameters));
                break;
            case LoyaltyPointsRule::WITHDRAW:
                $parameters->setAmount($amount);
                $context->setStrategy(new WithdrawAmountCalculationStrategy($parameters));
                break;
            default:
                $parameters->setAmount($amount);
                $context->setStrategy(new NoRuleCalculationStrategy($parameters));
                break;
        }

        return $context->execute();
    }

    private function findTransactionById(int $transactionId): LoyaltyPointsTransaction
    {
        return LoyaltyPointsTransaction::findOrFiail($transactionId);
    }

    private function getWithdrawAmount(float $amount): float
    {
        $context = new CalculationStrategyContext();
        $parameters = new CalculationStrategyParameters();
        $parameters->setAmount($amount);
        $context->setStrategy(new WithdrawAmountCalculationStrategy($parameters));
        return $context->execute();
    }
}
