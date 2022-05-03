<?php

namespace App\Http\Requests\Transaction;

use App\Models\LoyaltyAccount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CancelRequest extends FormRequest
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
            'transaction_id' => [
                'bail',
                'required',
                'exists:loyalty_points_transaction,id'
            ],
            'cancellation_reason' => [
                'bail',
                'required',
                'string'
            ]
        ];
    }
}
