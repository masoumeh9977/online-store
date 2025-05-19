<?php

namespace App\Services\Repositories\ModelRepositories;

use App\Models\Product;
use App\Services\Repositories\BaseRepository;

class ProductRepository extends BaseRepository
{
    public function __construct()
    {
       $this->model = new Product();
    }
}
