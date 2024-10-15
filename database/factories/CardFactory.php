<?php

namespace Database\Factories;

use App\Enums\CardType;
use App\Models\Account;
use App\Models\Card;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Card>
 */
class CardFactory extends Factory
{
    protected $model = Card::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cardType = fake()->randomElement(CardType::cases());
        return [
            'account_id' => Account::factory(),
            'card_type' => $cardType,
            'card_number' => $this->generateCardNumber(),
            'balance' => fake()->numberBetween(1000, 100000000),
        ];
    }

    private function generateCardNumber(): string
    {
        return fake()->numerify(str_repeat('#', 16));
    }
}
