<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
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
        $rules = [
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'description' => 'nullable|string',
            'photo' => 'required|string',
            'brand_id' => 'nullable|exists:brands,id',
            'cat_id' => 'nullable|exists:categories,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'concern_id' => 'nullable|exists:concerns,id',
            'child_concern_id' => 'nullable|exists:concerns,id',
            'ptype_id' => 'nullable|exists:product_types,id',
            'child_ptype_id' => 'nullable|exists:product_types,id',
            'routine_concern' => 'nullable|string',
            'presc' => 'nullable|string',
            'combo' => 'nullable|string',
            'pts' => 'required|string',
            'psr' => 'required|string',
            'hsn_no' => 'nullable|string',
            'cgst' => 'nullable|numeric',
            'sgst' => 'nullable|numeric',
            'tax' => 'nullable|numeric',
            'how_to_use' => 'nullable|string',
            'evidence' => 'nullable|string',
        ];
        return $rules;
    }
}
