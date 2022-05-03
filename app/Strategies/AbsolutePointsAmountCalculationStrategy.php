<?php

namespace App\Strategies;

use App\Interfaces\Strategies\IAmountCalculationStrategy;
use App\Strategies\Parameters\CalculationStrategyParameters;

class AbsolutePointsAmountCalculationStrategy implements IAmountCalculationStrategy
{
    private float $accrualValue;

    public function __construct(CalculationStrategyParameters $parameters)
    {
        $this->accrualValue = $parameters->getPaymentRule()->accrual_value;
    }

    public function apply(): float
    {
        return $this->accrualValue;
    }
}
