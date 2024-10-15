<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function accounts_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('accounts', [
            'id', 'user_id', 'account_number', 'balance', 'created_at', 'updated_at',
        ]), 1);
    }
}
