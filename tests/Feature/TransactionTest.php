<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Card;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function test_successful_transfer()
    {
        $user1 = User::factory()->create(['email' => 'user1@example.com']);
        $user2 = User::factory()->create(['email' => 'user2@example.com']);

        $account1 = Account::factory()->create(['user_id' => $user1->id]);
        $account2 = Account::factory()->create(['user_id' => $user2->id]);

        $card1 = Card::factory()->create(['account_id' => $account1->id, 'card_number' => '6273811234567960', 'balance' => 100000]);
        $card2 = Card::factory()->create(['account_id' => $account2->id, 'card_number' => '5022291234567430', 'balance' => 50000]);

        $response = $this->postJson('/api/v1/transfer', [
            'from_card' => '6273811234567960',
            'to_card' => '5022291234567430',
            'amount' => 10000,
        ]);

        $response->assertStatus(200)->assertJson(['success' => __('messages.transaction_success')]);

        $this->assertEquals(90000, $card1->fresh()->balance);
        $this->assertEquals(60000, $card2->fresh()->balance);
    }
}
