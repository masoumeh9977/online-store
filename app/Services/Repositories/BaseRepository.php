<?php

namespace App\Services\Repositories;


abstract class BaseRepository implements BaseRepositoryInterface
{
    public $model;

    public function all(array $conditions = [])
    {
        return $this->model::where($conditions)->get();
    }

    public function paginate(int $perPage = 4, array $conditions = [])
    {
        return $this->model::where($conditions)->paginate($perPage);
    }

    public function find($id)
    {
        return $this->model::find($id);

    }

    public function limit($limit, array $conditions = [])
    {
        return $this->model::where($conditions)->limit($limit)->get();
    }

    public function create(array $data)
    {
        return $this->model::create($data);
    }

    public function update($item, array $data)
    {
        return $item->update($data);
    }

    public function updateOrCreate(array $conditions, array $values)
    {
        return $this->model->updateOrCreate($conditions, $values);
    }


    public function delete($id, $conditions = [])
    {
        if ($id) {
            $item = $this->find($id);
            return $item?->delete();
        }
        return $this->model::where($conditions)->query()->delete();
    }
}
