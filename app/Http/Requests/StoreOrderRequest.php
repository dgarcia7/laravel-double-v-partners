<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'account_id' => ['required', 'exists:accounts,id'],
            'product' => ['required'],
            'quantity' => ['required', 'numeric'],
            'value' => ['required', 'numeric'],
        ];
    }
}
