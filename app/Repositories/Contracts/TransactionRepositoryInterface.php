<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface TransactionRepositoryInterface extends BaseRepositoryInterface
{
    public function getLastTransactionsByUser(int $userId, int $limit = 10): Collection;
}
