<?php

namespace App\Services;

use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserService
{
    protected $transactionRepository;
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository, TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->userRepository = $userRepository;
    }

    public function getTopUsers()
    {
        $topUsers = $this->userRepository->getTopUsers();

        return $topUsers->map(function ($user) {
            $transactions = $this->transactionRepository->getLastTransactionsByUser($user->id);

            return compact('user', 'transactions');
        });
    }
}
