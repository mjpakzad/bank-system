<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function transactions_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('transactions', [
            'id', 'from_card_id', 'to_card_id', 'amount', 'created_at', 'updated_at',
        ]), 1);
    }
}
