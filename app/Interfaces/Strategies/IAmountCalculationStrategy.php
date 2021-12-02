<?php

namespace App\Interfaces\Strategies;

use App\Strategies\Parameters\CalculationStrategyParameters;

interface IAmountCalculationStrategy
{
    public function __construct(CalculationStrategyParameters $parameters);

    public function apply(): float;
}
