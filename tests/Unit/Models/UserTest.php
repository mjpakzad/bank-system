<?php

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\Card;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function users_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('users', [
            'id', 'first_name', 'last_name', 'email', 'email_verified_at',
            'mobile', 'mobile_verified_at', 'password', 'remember_token',
            'created_at', 'updated_at',
        ]), 1);
    }

    #[Test]
    public function user_has_accounts()
    {
        $user = User::factory()->create();
        $account = Account::factory()->create(['user_id' => $user->id]);

        $this->assertTrue($user->accounts->contains($account));
    }

    #[Test]
    public function user_has_cards_through_accounts()
    {
        $user = User::factory()->create();
        $account = Account::factory()->create(['user_id' => $user->id]);
        $card = Card::factory()->create(['account_id' => $account->id]);

        $this->assertTrue($user->cards->contains($card));
    }
}
