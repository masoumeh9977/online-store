<?php

namespace App\Services\Repositories\ModelRepositories;

use App\Models\Category;
use App\Services\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository
{
    public function __construct()
    {
       $this->model = new Category();
    }
}
