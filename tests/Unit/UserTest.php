<?php

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
            'id', 'first_name', 'last_name', 'email', 'email_verified_at', 'mobile', 'mobile_verified_at', 'password', 'remember_token', 'created_at', 'updated_at',
        ]), 1);
    }
}
