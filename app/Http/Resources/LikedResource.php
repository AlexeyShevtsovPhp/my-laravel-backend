<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Good;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Good $resource
 */
class LikedResource extends JsonResource
{
    /**
     * @param mixed $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
        ];
    }
}
