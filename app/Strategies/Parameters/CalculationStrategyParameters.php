<?php

namespace App\Strategies\Parameters;

use App\Models\LoyaltyPointsRule;

class CalculationStrategyParameters
{
    private LoyaltyPointsRule $paymentRule;

    private float $amount;

    /**
     * @return LoyaltyPointsRule
     */
    public function getPaymentRule(): LoyaltyPointsRule
    {
        return $this->paymentRule;
    }

    /**
     * @param LoyaltyPointsRule $paymentRule
     */
    public function setPaymentRule(LoyaltyPointsRule $paymentRule): void
    {
        $this->paymentRule = $paymentRule;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }
}
