<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CardTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function cards_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('cards', [
            'id', 'account_id', 'card_number', 'created_at', 'updated_at',
        ]), 1);
    }
}
