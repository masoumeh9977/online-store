<?php

namespace App\Services\Repositories\ModelRepositories;

use App\Models\Discount;
use App\Services\Repositories\BaseRepository;

class DiscountRepository extends BaseRepository
{
    public function __construct()
    {
       $this->model = new Discount();
    }
}
