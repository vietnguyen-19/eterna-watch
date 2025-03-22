<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'price_default' => 'required|numeric|min:0',
            'short_description' => 'required|string|max:500',
            'full_description' => 'required|string',
            'avatar' => 'nullable',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'status' => 'required|in:active,inactive',
            'attribute_values' => 'required|array',
            'attribute_values.*' => 'exists:attribute_values,id'
        ];
    }

    
}
