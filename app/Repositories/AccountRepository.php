<?php

namespace App\Repositories;

use App\Models\Account;
use App\Repositories\Contracts\AccountRepositoryInterface;
use Illuminate\Http\Request;

class AccountRepository extends BaseRepository implements AccountRepositoryInterface
{
    /**
     * @return string
     */
    public function getModelName(): string
    {
        return Account::class;
    }
}
