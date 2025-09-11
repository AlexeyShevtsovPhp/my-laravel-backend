<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @implements RepositoryInterface<TModel>
 */

class BaseRepository implements RepositoryInterface
{
    /**
     * @var TModel
     */
    protected $model;

    /**
     * BaseRepository constructor.
     * @param TModel $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return Collection<int, TModel>
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * @param array<string, mixed> $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        $model = $this->model->create($attributes);
        /** @var TModel $model */
        return $model;
    }

    /**
     * @param Model $model
     * @param array<string, mixed> $data
     * @return Model
     */
    public function update(Model $model, array $data): Model
    {
        $model->update($data);
        return $model;
    }

    /**
     * @param Model $model
     * @return bool
     */
    public function delete(Model $model): bool
    {
        return (bool) $model->delete();
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function find($id): ?Model
    {
        $model = $this->model->find($id);
        /** @var TModel|null $model */
        return $model;
    }
}
