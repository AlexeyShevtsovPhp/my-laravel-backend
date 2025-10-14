<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Request;

class ImageUploadService
{
    /**
     * @param Request $request
     * @param string $field
     * @param string $folder
     * @return string|null
     */
    public function handle(Request $request, string $field = 'image', string $folder = 'images'): ?string
    {
        if (!$request->hasFile($field)) {
            return null;
        }

        $file = $request->file($field);
        $path = $file->store($folder, 'public');

        return $path === false ? null : $path;
    }
}
