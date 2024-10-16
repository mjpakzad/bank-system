<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TransactionRepository extends BaseRepository implements TransactionRepositoryInterface
{
    /**
     * @return string
     */
    public function getModelName(): string
    {
        return Transaction::class;
    }

    public function getLastTransactionsByUser(int $userId, int $limit = 10): Collection
    {
        return $this->getModel()
            ->query()
            ->whereHas('fromCard.account', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }
}
