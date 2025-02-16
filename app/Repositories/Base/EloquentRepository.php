<?php

namespace App\Repositories\Base;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EloquentRepository implements RepositoryInterface
{
    public function __construct(protected Model $model)
    {
    }

    public function getModelClass(): string
    {
        return get_class($this->model);
    }

    public function get(array $filters = [], array $select = ['*'], array $with = [], ?string $sortField = null, $sort = 'asc'): Collection
    {
        return $this->model::query()
            ->select($select)
            ->where($filters)
            ->with($with)
            ->when($sortField, function ($query, $sortField) use ($sort) {
                $query->orderBy($sortField, $sort);
            })
            ->get();
    }

    public function paginate(array $filters = [], array $select = ['*'], array $with = [], ?string $sortField = null, $sort = 'asc',  $pageSize = 24): LengthAwarePaginator
    {
        return $this->model::query()
            ->select($select)
            ->where($filters)
            ->with($with)
            ->when($sortField, function ($query, $sortField) use ($sort) {
                $query->orderBy($sortField, $sort);
            })
            ->paginate($pageSize);
    }

    public function create(array $attributes): Model
    {
        return $this->model::query()->create($attributes);
    }

    public function update(Model $model, array $attributes): Model
    {
        $model->fill($attributes)->save();

        return $this->find($model->id);
    }

    public function delete(Model $model): bool
    {
        return $model->delete();
    }

    public function find(int $id): Model
    {
        return $this->model::query()->findOrFail($id);
    }
}
