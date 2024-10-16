<?php

namespace App\Rules;

use App\Enums\BankName;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidCardNumber implements ValidationRule
{
    /**
     * Validate the card number.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cardNumber = preg_replace('/\D/', '', $value);

        if (strlen($cardNumber) != 16) {
            $fail($attribute, __('messages.card_number.invalid_length'));
        }

        $isValidPrefix = collect(BankName::cases())->contains(function ($bankName) use ($cardNumber) {
            return collect($bankName->prefixes())->contains(function ($prefix) use ($cardNumber) {
                return str_starts_with($cardNumber, $prefix);
            });
        });

        if(!$isValidPrefix) {
            $fail($attribute, __('messages.card_number.invalid_prefix'));
        }
    }
}
