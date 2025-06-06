<?php

namespace App\Services\Repositories\ModelRepositories;

use App\Models\Order;
use App\Services\Repositories\BaseRepository;

class OrderRepository extends BaseRepository
{
    public function __construct()
    {
       $this->model = new Order();
    }

    public function getByUserIdQuery(int $userId)
    {
        return Order::where('user_id', $userId);
    }
}
