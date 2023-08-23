<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Foundation\Http\FormRequest;

class CartUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'quantity' => 'required|integer|min:1',
        ];
    }
}
