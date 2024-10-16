<?php

namespace App\Http\Requests\API\V1;

use App\Helpers\NumberConverter;
use App\Rules\ValidCardNumber;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'from_card' => [
                'required',
                'string',
                new ValidCardNumber,
                'exists:cards,card_number',
            ],
            'to_card' => [
                'required',
                'string',
                'different:from_card',
                new ValidCardNumber,
                'exists:cards,card_number',
            ],
            'amount' => 'required|numeric|min:1000|max:50000000',
        ];
    }

    public function messages()
    {
        return [
            'amount.min' => __('messages.amount_min'),
            'amount.max' => __('messages.amount_max'),
            'to_card.different' => __('messages.to_card_different'),
            'from_card.exists' => __('messages.from_card_not_found'),
            'to_card.exists' => __('messages.to_card_not_found'),
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'from_card' => NumberConverter::toEnglish($this->from_card),
            'to_card' => NumberConverter::toEnglish($this->to_card),
            'amount' => NumberConverter::toEnglish($this->amount),
        ]);
    }
}
