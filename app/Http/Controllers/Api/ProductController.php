<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Services\Repositories\ModelRepositories\CategoryRepository;
use App\Services\Repositories\ModelRepositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected ProductRepository  $repository,
                                protected CategoryRepository $categoryRepository)
    {
    }

    public function fetch(Request $request, $category = null)
    {
        $condition = [];
        if ($category) {
            $category = $this->categoryRepository->all(['name' => $category])?->first();
            $condition['category_id'] = $category->id;
        }
        $products = $this->repository->paginate(conditions:  $condition);
        return ProductResource::collection($products);
    }

}
