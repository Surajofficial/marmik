<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductVariantRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'size' => 'nullable|exists:streps,id', // Validate that size exists in the streps table
            'sku' => [
                'required',
                'string',
                Rule::unique('product_variants', 'sku')->ignore($this->route('variant')), // Unique rule for both create and update
            ],
            'status' => 'required|in:active,inactive',
            'width' => 'nullable|string|max:255',
            'height' => 'nullable|string|max:255',
            'length' => 'nullable|string|max:255',
            'weight' => 'nullable|string|max:255',
            'rules' => 'nullable|json',
            'is_featured' => 'nullable|boolean',
            'is_best_seller' => 'nullable|boolean',
            'special_price' => 'nullable',
            'price' => 'required',
        ];
    }
}
