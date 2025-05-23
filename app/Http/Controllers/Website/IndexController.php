<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaseResource;
use App\Models\IranProvince;
use App\Services\Repositories\ModelRepositories\ProductRepository;

class IndexController extends Controller
{
    public function index(ProductRepository $repository)
    {
        $products = $repository->limit(4);
        return view('website.index', compact('products'));
    }

    public function getCities(IranProvince $province)
    {
        try {
            return BaseResource::success($province->cities);
        } catch (\Exception $e) {
            logger()->error($e);
            return BaseResource::error($e->getMessage());
        }
    }
}
