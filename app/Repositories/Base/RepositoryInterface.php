<?php

namespace App\Repositories\Base;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function get(array $filters = [], array $select = [], array $with = [], ?string $sortField = null, $sort = 'asc'): Collection;

    public function paginate(array $filters = [], array $select = [], array $with = [], ?string $sortField = null, $sort = 'asc',  $pageSize = 24): LengthAwarePaginator;

    public function create(array $attributes): Model;

    public function update(Model $model, array $attributes): Model;

    public function delete(Model $model): bool;

    public function find(int $id): Model;

    public function getModelClass(): string;
}
