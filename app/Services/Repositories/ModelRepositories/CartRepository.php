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

    public function getCartWithoutOrderForUser($userId)
    {
        return $this->model::where('user_id', $userId)
            ->whereDoesntHave('order')
            ->first();
    }
}
