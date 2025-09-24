<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ToggleLikeResource extends JsonResource
{
    /**
     * @param mixed $request
     * @return array<string, bool>
     */
    public function toArray($request): array
    {
        JsonResource::withoutWrapping();

        return ['liked' => $this->resource];
    }
}
