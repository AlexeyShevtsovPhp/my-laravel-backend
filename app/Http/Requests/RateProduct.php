<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RateProduct extends FormRequest
{
    /**
     * @return bool
     */

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */

    /**
     * @return string[]
     */

    public function rules(): array
    {
        return [
            'productId' => 'required|integer|exists:goods,id',
            'userId' => 'required|integer|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
        ];
    }

    /**
     * @return string[]
     */

    public function messages(): array
    {
        return [
            'productId.required' => 'ID товара обязателен.',
            'productId.exists' => 'Товар не найден.',
            'userId.required' => 'ID пользователя обязателен.',
            'userId.exists' => 'Пользователь не найден.',
            'rating.required' => 'Оценка обязательна.',
            'rating.min' => 'Минимальная оценка 1.',
            'rating.max' => 'Максимальная оценка 5.',
        ];
    }
}
