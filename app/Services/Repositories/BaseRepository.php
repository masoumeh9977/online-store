<?php

namespace App\Services\Repositories;


abstract class BaseRepository implements BaseRepositoryInterface
{
    public $model;

    public function all(array $conditions = [])
    {
        return $this->model::where($conditions)->get();
    }

    public function paginate(int $perPage = 15, array $conditions = [])
    {
        return $this->model::where($conditions)->paginate($perPage);
    }

    public function find($id)
    {
        return $this->model::find($id);

    }

    public function create(array $data)
    {
        return $this->model::create($data);
    }

    public function update($item, array $data)
    {
        return $item->update($data);
    }

    public function delete($id, $conditions = [])
    {
        if ($id) {
            $product = $this->find($id);
            return $product?->delete();
        }
        return $this->model::where($conditions)->query()->delete();
    }
}
