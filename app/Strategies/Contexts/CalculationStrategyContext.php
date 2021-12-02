<?php

namespace App\Strategies\Contexts;

use App\Interfaces\Strategies\IAmountCalculationStrategy;

class CalculationStrategyContext
{
    private IAmountCalculationStrategy $strategy;

    public function execute(): float {
        return $this->strategy->apply();
    }

    public function setStrategy(IAmountCalculationStrategy $strategy) {
        $this->strategy = $strategy;
    }
}
