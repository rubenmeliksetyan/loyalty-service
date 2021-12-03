<?php

namespace App\Http\Requests\Transaction;

use App\Models\LoyaltyAccount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WithdrawRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account_type' => [
                'bail',
                'required',
                Rule::in(LoyaltyAccount::ALLOWED_TYPES)
            ],
            'account_id' => [
                'bail',
                'required',
                'exists:loyalty_account,'. $this->input('account_type')
            ],
            'points_amount' => ['required','numeric'],
            'description' => ['sometimes','string'],
        ];
    }
}
