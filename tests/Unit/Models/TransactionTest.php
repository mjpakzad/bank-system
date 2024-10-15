<?php

namespace Tests\Unit\Models;

use App\Models\Card;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;


class TransactionTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function transactions_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('transactions', [
            'id', 'from_card_id', 'to_card_id', 'amount',
            'created_at', 'updated_at',
        ]), 1);
    }

    #[Test]
    public function test_transaction_belongs_to_from_card()
    {
        $fromCard = Card::factory()->create();
        $toCard = Card::factory()->create();
        $transaction = Transaction::factory()->create([
            'from_card_id' => $fromCard->id,
            'to_card_id'   => $toCard->id,
        ]);

        $this->assertInstanceOf(Card::class, $transaction->fromCard);
        $this->assertEquals($fromCard->id, $transaction->fromCard->id);
    }

    #[Test]
    public function test_transaction_belongs_to_to_card()
    {
        $fromCard = Card::factory()->create();
        $toCard = Card::factory()->create();
        $transaction = Transaction::factory()->create([
            'from_card_id' => $fromCard->id,
            'to_card_id'   => $toCard->id,
        ]);

        $this->assertInstanceOf(Card::class, $transaction->toCard);
        $this->assertEquals($toCard->id, $transaction->toCard->id);
    }
}
