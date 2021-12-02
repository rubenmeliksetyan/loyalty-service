<?php

namespace App\Strategies;

use App\Interfaces\Strategies\IAmountCalculationStrategy;
use App\Strategies\Parameters\CalculationStrategyParameters;

class NoRuleCalculationStrategy implements IAmountCalculationStrategy
{
    private float $amount;

    public function __construct(CalculationStrategyParameters $parameters)
    {
        $this->amount = $parameters->getAmount();
    }

    public function apply(): float
    {
        return $this->amount;
    }
}
