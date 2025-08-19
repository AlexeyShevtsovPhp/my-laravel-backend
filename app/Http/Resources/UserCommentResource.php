<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Comment;

/**
 * @property Comment $resource
 */

class UserCommentResource extends JsonResource
{
    /**
     * @param $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'content' => $this->resource->content,
            'category_id' => $this->resource->category_id,
        ];
    }
}
