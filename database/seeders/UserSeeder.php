<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Card;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory()
            ->count(10)
            ->has(
                Account::factory()
                    ->count(4)
                    ->has(
                        Card::factory()
                            ->count(3)
                            ->state(function (array $attributes, Account $account) {
                                return [
                                    'balance' => rand(100000, 500000),
                                ];
                            })
                    )
            )
            ->create();
        $allCards = Card::query()->get();

        foreach ($allCards as $fromCard) {
            $transactionCount = rand(1, 5);

            for ($i = 0; $i < $transactionCount; $i++) {
                $toCard = $allCards->where('id', '!=', $fromCard->id)->random();

                $amount = rand(1000, 50000);

                if ($fromCard->balance >= $amount) {
                    Transaction::query()->create([
                        'from_card_id' => $fromCard->id,
                        'to_card_id'   => $toCard->id,
                        'amount'       => $amount,
                    ]);

                    $fromCard->query()->decrement('balance', $amount);
                    $toCard->query()->increment('balance', $amount);
                }
            }
        }

        User::factory()->has(Account::factory()->has(Card::factory(['card_number' => '6273811234567890', 'balance' => '10000000'])))->create();
        User::factory()->has(Account::factory()->has(Card::factory(['card_number' => '5022291234567890', 'balance' => '98000000'])))->create();
    }
}
