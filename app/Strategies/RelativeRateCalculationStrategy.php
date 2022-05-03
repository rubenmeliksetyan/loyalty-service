<?php

namespace App\Strategies;

use App\Interfaces\Strategies\IAmountCalculationStrategy;
use App\Strategies\Parameters\CalculationStrategyParameters;

class RelativeRateCalculationStrategy implements IAmountCalculationStrategy
{
    private float $accrualValue;
    private float $paymentAmount;

    public function __construct(CalculationStrategyParameters $parameters)
    {
        $this->accrualValue = $parameters->getPaymentRule()->accrual_value;
        $this->paymentAmount = $parameters->getAmount();
    }

    public function apply(): float
    {
        return ($this->paymentAmount / 100) * $this->accrualValue;
    }
}
