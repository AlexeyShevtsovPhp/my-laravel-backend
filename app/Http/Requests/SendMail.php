<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SendMail extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ];
    }

    /**
     * @return string[]
     */

    public function messages(): array
    {
        return [
            'name.required' => 'Должно быть обязательно указано имя отправителя',
            'subject.required' => 'Тема сообщения должна быть заполнена',
            'message.required' => 'Поле с письмом не должно быть пустым',
        ];
    }
}
