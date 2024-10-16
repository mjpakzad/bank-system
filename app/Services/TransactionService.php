<?php

namespace App\Services;

use App\Exceptions\InsufficientBalanceException;
use App\Notifications\BalanceChangedNotification;
use App\Repositories\Contracts\CardRepositoryInterface;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Strategies\StandardTransactionStrategy;
use Illuminate\Support\Facades\Notification;
use Throwable;

class TransactionService
{
    protected $transactionRepository;
    protected $cardRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository, CardRepositoryInterface $cardRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->cardRepository = $cardRepository;
    }

    /**
     * Transfer money between two cards.
     *
     * @param array $data
     * @return array
     * @throws Throwable
     */
    public function transfer(array $data): array
    {
        ['from_card' => $fromCardNumber, 'to_card' => $toCardNumber, 'amount' => $amount] = $data;

        $fromCard = $this->cardRepository->findByCardNumber($fromCardNumber, true);
        $toCard = $this->cardRepository->findByCardNumber($toCardNumber);

        throw_if($fromCard->balance < $amount, InsufficientBalanceException::class);

        $strategy = new StandardTransactionStrategy();
        $strategy->execute($fromCard, $toCard, $amount);

        $transaction = $this->transactionRepository->create(['from_card_id' => $fromCard->id, 'to_card_id' => $toCard->id, 'amount' => $amount]);

        Notification::send($fromCard->account->user, new BalanceChangedNotification(-$amount));
        Notification::send($toCard->account->user, new BalanceChangedNotification($amount));

        return ['success' =>  __('messages.transaction_success'), 'transaction_id' => $transaction->id];
    }
}
