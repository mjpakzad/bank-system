<?php

return [
    'email_subject' => 'Balance Change Email',
    'greeting' => 'Hello :name,',
    'deposit_message' => 'An amount of :amount Tomans has been deposited to your account.',
    'withdraw_message' => 'An amount of :amount Tomans has been withdrawn from your account.',
    'thanks' => 'Thank you,',
    'bank_system' => 'Banking System',

    'invalid_card' => 'Invalid card number.',
    'insufficient_balance' => 'Insufficient balance.',
    'transaction_success' => 'Transaction completed successfully.',
    'from_card_not_found' => 'Source card not found.',
    'to_card_not_found' => 'Destination card not found.',
    'amount_min' => 'The minimum allowed amount is 1,000 Tomans.',
    'amount_max' => 'The maximum allowed amount is 50,000,000 Tomans.',
    'to_card_different' => 'The destination card number must be different from the source card.',
    'card_number' => [
        'invalid_length' => 'The card number must be 16 digits.',
        'invalid_prefix' => 'Invalid card prefix!',
    ],
];
