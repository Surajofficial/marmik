<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StockRequest extends FormRequest
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
            'center_id' => 'required|exists:centers,id',
            'variant_id' => 'required|exists:product_variants,id',
            'stock' => 'required|integer|min:0',
            'mfg' => 'required|string|max:17',
            'expiry' => 'required|string|max:17',
            // 'batch_no' => [
            //     'required',
            //     'string',
            //     Rule::unique('stocks', 'batch_no')->ignore($this->route('stock')), // Corrected: reference to 'stock'
            // ],
            'batch_no' => [
                'required',
                'string',
                Rule::unique('stocks')->where(function ($query) {
                    return $query->where('center_id', $this->center_id);
                })->ignore($this->route('stock')), // Corrected: reference to 'stock'
            ],
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
        ];
    }
}
