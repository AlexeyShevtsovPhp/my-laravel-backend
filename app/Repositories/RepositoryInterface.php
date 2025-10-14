<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    /**
     * @return Collection<int, Model>
     */
    public function all(): Collection;

    /**
     * @param array<string, mixed> $data
     * @return Model
     */
    public function create(array $data): Model;

    /**
     * @param Model $model
     * @param array<string, mixed> $data
     * @return Model
     */
    public function update(Model $model, array $data): Model;

    /**
     * @param Model $model
     * @return bool
     */
    public function delete(Model $model): bool;

    /**
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model;
}
