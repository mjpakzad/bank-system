<?php

namespace Tests\Unit\Services;

use App\Exceptions\InsufficientBalanceException;
use App\Models\Account;
use App\Models\Card;
use App\Models\User;
use App\Services\TransactionService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TransactionServiceTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function test_transfer_successful()
    {
        $service = resolve(TransactionService::class);

        $user1 = User::factory()->create(['email' => 'user1@example.com']);
        $user2 = User::factory()->create(['email' => 'user2@example.com']);

        $account1 = Account::factory()->create(['user_id' => $user1->id]);
        $account2 = Account::factory()->create(['user_id' => $user2->id]);

        $card1 = Card::factory()->create(['account_id' => $account1->id, 'card_number' => '6273811234567892', 'balance' => 100000]);
        $card2 = Card::factory()->create(['account_id' => $account2->id, 'card_number' => '5022291234567892', 'balance' => '50000']);

        $result = $service->transfer(['from_card' => '6273811234567892', 'to_card' => '5022291234567892', 'amount' => 10000]);

        $this->assertArrayHasKey('success', $result);
        $this->assertEquals(__('messages.transaction_success'), $result['success']);
        $this->assertEquals(90000, $card1->fresh()->balance);
        $this->assertEquals(60000, $card2->fresh()->balance);
    }

    #[Test]
    public function transfer_insufficient_balance()
    {
        $service = resolve(TransactionService::class);

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $account1 = Account::factory()->create(['user_id' => $user1->id]);
        $account2 = Account::factory()->create(['user_id' => $user2->id]);

        $card1 = Card::factory()->create([
            'account_id'  => $account1->id,
            'card_number' => '6273811234567891',
            'balance'     => 5000,
        ]);

        $card2 = Card::factory()->create([
            'account_id'  => $account2->id,
            'card_number' => '5022291234567891',
            'balance'     => 50000,
        ]);

        $this->expectException(InsufficientBalanceException::class);
        $this->expectExceptionMessage(__('messages.insufficient_balance'));

        $service->transfer(array(
            'from_card' => '6273811234567891',
            'to_card'   => '5022291234567891',
            'amount'    => 10000,
        ));
    }
}
