<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Services\Repositories\ModelRepositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected ProductRepository $repository)
    {
    }

    public function fetch(Request $request)
    {
        $products = $this->repository->paginate(10);
        return ProductResource::collection($products);
    }

}
