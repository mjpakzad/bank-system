<?php

namespace Tests\Unit\Models;

use App\Enums\BankName;
use App\Models\Account;
use App\Models\Card;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function accounts_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('accounts', [
            'id', 'user_id', 'bank_name', 'account_number',
            'created_at', 'updated_at',
        ]), 1);
    }

    #[Test]
    public function account_belongs_to_user()
    {
        $user = User::factory()->create();
        $account = Account::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $account->user);
        $this->assertEquals($user->id, $account->user->id);
    }

    #[Test]
    public function account_has_many_cards()
    {
        $account = Account::factory()->create();
        $cards = Card::factory()->count(2)->create(['account_id' => $account->id]);

        $this->assertCount(2, $account->cards);
        $this->assertTrue($account->cards->contains($cards[0]));
        $this->assertTrue($account->cards->contains($cards[1]));
    }

    #[Test]
    public function valid_account_creation()
    {
        $user = User::factory()->create();
        $account = Account::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(BankName::class, $account->bank_name);
        $this->assertTrue(strlen($account->account_number) >= 8 && strlen($account->account_number) <= 12);
    }
}
