<?php

namespace App\Repositories\Contracts;

use App\Models\Card;

interface CardRepositoryInterface extends BaseRepositoryInterface
{
    public function findByCardNumber(string $cardNumber, bool $lockForUpdate = false): ?Card;
}
