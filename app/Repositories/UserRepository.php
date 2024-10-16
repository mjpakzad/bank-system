<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @return string
     */
    public function getModelName(): string
    {
        return User::class;
    }

    public function getTopUsers($minutes = 10, $limit = 3): Collection
    {
        $tenMinutesAgo = Carbon::now()->subMinutes($minutes);

        return $this->getModel()
            ->query()
            ->select('users.id', 'users.first_name', 'users.last_name', DB::raw('COUNT(transactions.id) as transactions_count'))
            ->join('accounts', 'users.id', '=', 'accounts.user_id')
            ->join('cards', 'accounts.id', '=', 'cards.account_id')
            ->join('transactions', function ($join) use ($tenMinutesAgo) {
                $join->on('cards.id', '=', 'transactions.from_card_id')
                    ->orOn('cards.id', '=', 'transactions.to_card_id')
                    ->where('transactions.created_at', '>=', $tenMinutesAgo);
            })
            ->groupBy('users.id', 'users.first_name', 'users.last_name')
            ->orderByDesc('transactions_count')
            ->limit($limit)
            ->get();
    }
}
