<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => "required|string",
            'slug' => "required|string",
            'category_id' => ["required", "exists:categories,id"],
            'primary_image' => "nullable|image",
            'description' => "required|string",
            'price' => "required|numeric",
            'quantity' => "required|numeric",
            'sale_price' => "required|numeric",
            'date_on_sale_from' => "nullable|date_format:Y/m/d H:i:s",
            'date_on_sale_to' => "nullable|date_format:Y/m/d H:i:s",
            'status' => "nullable|boolean",
            'images.*' => "nullable|image"
        ];
    }
}
