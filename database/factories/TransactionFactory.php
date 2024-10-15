<?php

namespace Database\Factories;

use App\Models\Card;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'from_card_id' => Card::factory(),
            'to_card_id' => Card::factory(),
            'amount' => fake()->numberBetween(1000, 50000000),
        ];
    }
}
