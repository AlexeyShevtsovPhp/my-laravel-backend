<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddCartItem extends FormRequest
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
            'product_id' => 'required|integer|exists:goods,id',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Идентификатор товара обязателен',
            'product_id.integer' => 'Идентификатор товара должен быть числом',
            'product_id.exists' => 'Товар с таким идентификатором не найден',
        ];
    }
}
