<?php

namespace App\Http\Controllers\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'filled|string|max:255',
            'price' => 'filled|numeric|min:0',
            'description' => 'nullable|string',
            'photo' => 'nullable|string',
        ];
    }
}
