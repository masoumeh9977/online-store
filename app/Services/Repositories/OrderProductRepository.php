<?php

namespace App\Services\Repositories;

use App\Models\OrderProduct;

class OrderProductRepository implements BaseRepositoryInterface
{

    public function all(array $conditions = [])
    {
        return OrderProduct::where($conditions)->get();

    }

    public function paginate(int $perPage = 15, array $conditions = [])
    {
        return OrderProduct::where($conditions)->paginate($perPage);

    }

    public function find($id, $conditions = [])
    {
        return OrderProduct::find($id);

    }

    public function create(array $data)
    {
        return OrderProduct::create($data);

    }

    public function update($item, array $data)
    {
        return $item->update($data);
    }

    public function delete($id, $conditions = [])
    {
        if ($id) {
            $item = $this->find($id);
            return $item?->delete();
        }
        return OrderProduct::where($conditions)->query()->delete();
    }
}
