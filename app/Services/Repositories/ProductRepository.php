<?php

namespace App\Services\Repositories;

use App\Models\Product;

class ProductRepository implements BaseRepositoryInterface
{

    public function all(array $conditions = [])
    {
        return Product::where($conditions)->get();
    }

    public function paginate(int $perPage = 15, array $conditions = [])
    {
        return Product::where($conditions)->paginate($perPage);
    }

    public function find($id)
    {
        return Product::find($id);

    }

    public function create(array $data)
    {
        return Product::create($data);
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
        return Product::where($conditions)->query()->delete();
    }
}
