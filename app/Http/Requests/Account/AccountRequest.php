<?php

namespace App\Http\Requests\Account;

use App\Models\LoyaltyAccount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountRequest extends FormRequest
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
            'type' => [
                'bail',
                'required',
                Rule::in(LoyaltyAccount::ALLOWED_TYPES)
            ],
            'id' => [
                'bail',
                'required',
                'exists:loyalty_account,'. $this->route('type')
            ]
        ];
    }

    public function prepareForValidation()
    {
        $this->merge(['id' => $this->route('id'), 'type' => $this->route('type')]);
    }
}
