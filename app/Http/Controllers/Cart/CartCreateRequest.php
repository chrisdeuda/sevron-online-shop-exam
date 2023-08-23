<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Foundation\Http\FormRequest;

class CartCreateRequest extends  FormRequest
{
    public function rules()
    {
        return [
            'id' => 'required|uuid',
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'attributes.image' => 'nullable|string', // Adjust the validation rule as needed
        ];
    }

}
