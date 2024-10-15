<?php

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\Card;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CardTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function cards_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('cards', [
            'id', 'account_id', 'card_type', 'card_number',
            'created_at', 'updated_at',
        ]), 1);
    }

    #[Test]
    public function card_belongs_to_account()
    {
        $account = Account::factory()->create();
        $card = Card::factory()->create(['account_id' => $account->id]);

        $this->assertInstanceOf(Account::class, $card->account);
        $this->assertEquals($account->id, $card->account->id);
    }

    #[Test]
    public function valid_card_creation()
    {
        $card = Card::factory()->create();

        $this->assertEquals(16, strlen($card->card_number));
        $this->assertTrue(is_numeric($card->card_number));
    }
}
