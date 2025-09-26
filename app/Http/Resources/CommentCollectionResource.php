<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @property Comment|LengthAwarePaginator<int, Comment> $resource
 */
class CommentCollectionResource extends ResourceCollection
{
    /**
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return ['data' => CommentResource::collection($this->collection)];
    }

    /**
     * @param Request $request
     * @return array<string, mixed>
     */
    public function with(Request $request): array
    {
        $meta = [];

        if ($this->resource instanceof LengthAwarePaginator) {
            $meta = [
                'current_page' => $this->resource->currentPage(),
                'last_page' => $this->resource->lastPage(),
                'total' => $this->resource->total(),
            ];
        }

        return ['meta' => $meta];
    }


    /**
     * @param Request $request
     * @param array<string, mixed> $default
     * @return array<string, mixed>
     */
    public function paginationInformation(Request $request, array $default): array
    {
        unset($default['links']);
        unset($default['from']);
        unset($default['to']);
        unset($default['path']);
        unset($default['last_page_url']);
        unset($default['next_page_url']);
        unset($default['prev_page_url']);
        unset($default['per_page']);
        unset($default['last_page']);
        unset($default['current_page']);
        unset($default['total']);
        unset($default['first_page_url']);
        unset($default['data']);

        return $default;
    }
}
