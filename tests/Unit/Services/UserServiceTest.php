<?php

namespace Tests\Unit\Services;

use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function get_top_users()
    {
        $userService = resolve(UserService::class);

        $topUsers = $userService->getTopUsers();

        $this->assertCount(3, $topUsers);

        foreach ($topUsers as $topUser) {
            $this->assertArrayHasKey('user', $topUser);
            $this->assertArrayHasKey('transactions', $topUser);
            $this->assertLessThanOrEqual(10, $topUser['transactions']->count());
        }
    }

    #[Test]
    public function get_top_users_with_mock()
    {
        $userRepositoryMock = $this->createMock(UserRepositoryInterface::class);

        $userRepositoryMock->method('getTopUsers')
            ->willReturn(new EloquentCollection([
                (object)[
                    'id' => 1,
                    'first_name' => 'Mojtaba',
                    'last_name' => 'Pakzad',
                    'transactions_count' => 5,
                ],
                (object)[
                    'id' => 2,
                    'first_name' => 'Ashkan',
                    'last_name' => 'Pakzad',
                    'transactions_count' => 3,
                ],
                (object)[
                    'id' => 3,
                    'first_name' => 'Kenshi',
                    'last_name' => 'Pakzad',
                    'transactions_count' => 2,
                ],
            ]));

        $transactionRepositoryMock = $this->createMock(TransactionRepositoryInterface::class);

        $transactionRepositoryMock->method('getLastTransactionsByUser')
            ->willReturn(new EloquentCollection([
                (object)[
                    'id' => 1,
                    'amount' => 1000,
                    'created_at' => now(),
                ],
                (object)[
                    'id' => 2,
                    'amount' => 2000,
                    'created_at' => now(),
                ],
            ]));


        $userService = new UserService($userRepositoryMock, $transactionRepositoryMock);

        $topUsers = $userService->getTopUsers();

        $this->assertCount(3, $topUsers);

        foreach ($topUsers as $topUser) {
            $this->assertArrayHasKey('user', $topUser);
            $this->assertArrayHasKey('transactions', $topUser);
            $this->assertLessThanOrEqual(10, $topUser['transactions']->count());
        }
    }
}
