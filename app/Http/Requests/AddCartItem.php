<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AddCartItem extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
    /**
     *
     * @return array<string, ValidationRule|array|string>
     */
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|integer|exists:goods,id',
        ];
    }
    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'product_id.required' => 'Идентификатор товара обязателен',
            'product_id.integer' => 'Идентификатор товара должен быть числом',
            'product_id.exists' => 'Товар с таким идентификатором не найден',
        ];
    }
}
