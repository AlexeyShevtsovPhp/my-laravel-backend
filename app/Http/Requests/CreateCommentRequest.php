<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'content' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id',
        ];
    }
}
