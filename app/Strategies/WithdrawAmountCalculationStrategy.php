<?php

namespace App\Strategies;

use App\Interfaces\Strategies\IAmountCalculationStrategy;
use App\Strategies\Parameters\CalculationStrategyParameters;

class WithdrawAmountCalculationStrategy implements IAmountCalculationStrategy
{

    private float $paymentAmount;

    public function __construct(CalculationStrategyParameters $parameters)
    {
        $this->paymentAmount = $parameters->getAmount();
    }

    public function apply(): float
    {
        return -$this->paymentAmount;
    }
}
