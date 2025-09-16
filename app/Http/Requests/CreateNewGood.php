<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateNewGood extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|string|array<string>>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|integer|exists:categories,id',
            'image' => 'nullable|file|image|mimes:png|max:1024',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'image.mimes' => 'Фото должно быть в формате png',
            'image.max' => 'Фото должно быть не больше 1 мб',
            'name.required' => 'Название товара обязательно',
            'price.required' => 'Цена товара нужна обязательна',
            'price.numeric' => 'Цена должна быть только числом',
        ];
    }
}
