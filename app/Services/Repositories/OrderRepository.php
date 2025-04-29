<?php

namespace App\Services\Repositories;

use App\Models\Order;

class OrderRepository implements BaseRepositoryInterface
{

    public function all(array $conditions = [])
    {
        return Order::where($conditions)->get();
    }

    public function paginate(int $perPage = 15, array $conditions = [])
    {
        return Order::where($conditions)->paginate($perPage);
    }

    public function find($id)
    {
        return Order::find($id);

    }

    public function create(array $data)
    {
        return Order::create($data);
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
        return Order::where($conditions)->query()->delete();
    }
}
