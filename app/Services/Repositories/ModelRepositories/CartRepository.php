<?php

namespace App\Services\Repositories\ModelRepositories;

use App\Models\Cart;
use App\Services\Repositories\BaseRepository;

class CartRepository extends BaseRepository
{
    public function __construct()
    {
       $this->model = new Cart();
    }
}
