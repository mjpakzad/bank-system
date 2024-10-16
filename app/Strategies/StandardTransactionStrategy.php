<?php

namespace App\Strategies;

use App\Strategies\Contracts\TransactionStrategyInterface;
use Illuminate\Support\Facades\DB;

class StandardTransactionStrategy implements TransactionStrategyInterface
{

    /**
     * @param $fromCard
     * @param $toCard
     * @param $amount
     * @return mixed
     */
    public function execute($fromCard, $toCard, $amount)
    {
        return DB::transaction(function () use ($fromCard, $toCard, $amount) {
            $fromCard->decrement('balance', $amount);
            $toCard->increment('balance', $amount);
        });
    }
}
