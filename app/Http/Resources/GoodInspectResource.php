<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Good;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Good $resource
 * @property string|null $image
 */
class GoodInspectResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        JsonResource::withoutWrapping();

        $user = $request->user();

        $userRating = null;
        if ($user) {
            $ratingModel = $this->resource->ratings()->where('user_id', $user->id)->first();
            if ($ratingModel) {
                $userRating = $ratingModel->rating;
            }
        }
        $averageRating = $this->resource->ratings()->avg('rating');

        return [
            'item' => [
                'id' => $this->resource->id,
                'name' => $this->resource->name,
                'image' => $this->resource->image,
                'price' => $this->resource->price,
                'created_at' => $this->resource->created_at,
                'user_rating' => $userRating,
                'average_rating' => $averageRating,
            ]];
    }
}
