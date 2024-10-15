<?php

namespace Database\Factories;

use App\Enums\BankName;
use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Account>
 */
class AccountFactory extends Factory
{
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $bankName = fake()->randomElement(BankName::cases());
        return [
            'user_id' => User::factory(),
            'bank_name' => $bankName,
            'account_number' => $this->generateAccountNumber($bankName),
            'balance' => fake()->numberBetween(1000, 100000000),
        ];
    }

    private function generateAccountNumber(BankName $bankName): string
    {
        $length = fake()->numberBetween(8, 12);
        return fake()->numerify(str_repeat('#', $length));
    }
}
