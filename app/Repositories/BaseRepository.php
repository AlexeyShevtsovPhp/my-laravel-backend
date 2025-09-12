<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements RepositoryInterface
{
    /**
     * @var Model
     */
    protected Model $model;
    /**
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    /**
     * @return Collection<int, Model>
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
        return $this->model->create($attributes);
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
     * @param $id
     * @return Model|null
     */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }
}
