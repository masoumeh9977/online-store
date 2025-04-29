<?php

namespace App\Services\Repositories;

use App\Models\Discount;

class DiscountRepository implements BaseRepositoryInterface
{

    public function all(array $conditions = [])
    {
        return Discount::where($conditions)->get();
    }

    public function paginate(int $perPage = 15, array $conditions = [])
    {
        return Discount::where($conditions)->paginate($perPage);
    }

    public function find($id)
    {
        return Discount::find($id);

    }

    public function create(array $data)
    {
        return Discount::create($data);
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
        return Discount::where($conditions)->query()->delete();
    }
}
