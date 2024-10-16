<?php

namespace App\Strategies\Contracts;

interface TransactionStrategyInterface
{
    public function execute($fromCard, $toCard, $amount);
}
