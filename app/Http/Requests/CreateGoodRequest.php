<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateGoodRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|integer|exists:categories,id',
            'image' => 'nullable|file|image|mimes:png|max:1024',
        ];
    }

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
