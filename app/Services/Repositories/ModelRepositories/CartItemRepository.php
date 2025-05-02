<?php

namespace App\Services\Repositories\ModelRepositories;

use App\Models\CartItem;
use App\Services\Repositories\BaseRepository;

class CartItemRepository extends BaseRepository
{
    public function __construct()
    {
       $this->model = new CartItem();
    }
}
