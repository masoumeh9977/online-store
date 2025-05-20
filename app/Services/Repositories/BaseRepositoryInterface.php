<?php

namespace App\Services\Repositories;

interface BaseRepositoryInterface
{
    public function all(array $conditions = []);

    public function paginate(int $perPage = 15, array $conditions = []);

    public function find($id);

    public function create(array $data);

    public function update($item, array $data);
    public function updateOrCreate(array $conditions, array $values);

    public function delete($id, $conditions = []);

}
