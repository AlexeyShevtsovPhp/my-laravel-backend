<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;

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
     * @param AbstractPaginator<int, mixed> $paginated
     * @param array<string, mixed> $default
     * @return array<string, mixed>
     */
    public function paginationInformation(Request $request, AbstractPaginator $paginated, array $default): array
    {
        unset($default['links']);
        unset($default['meta']['from']);
        unset($default['meta']['to']);
        unset($default['meta']['links']);
        unset($default['meta']['path']);

        return $default;
    }
}
