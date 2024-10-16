<?php

namespace App\Repositories;

use App\Models\Card;
use App\Repositories\Contracts\CardRepositoryInterface;
use Illuminate\Http\Request;

class CardRepository extends BaseRepository implements CardRepositoryInterface
{
    /**
     * @return string
     */
    public function getModelName(): string
    {
        return Card::class;
    }

    public function findByCardNumber(string $cardNumber, bool $lockForUpdate = false): ?Card
    {
        $query = $this->getModel()->where('card_number', $cardNumber);

        if ($lockForUpdate) {
            $query->lockForUpdate();
        }

        return $query->first();
    }
}
