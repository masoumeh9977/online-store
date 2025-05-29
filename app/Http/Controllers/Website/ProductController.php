<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CartService;
use App\Services\Repositories\ModelRepositories\CategoryRepository;
use App\Services\Repositories\ModelRepositories\ProductRepository;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct(protected CartService        $cartService,
                                protected ProductRepository  $productRepository,
                                protected CategoryRepository $categoryRepository)
    {
    }

    public function index($category = null)
    {
        $condition = [];
        if ($category) {
            $category = $this->categoryRepository->all(['name' => $category])?->first();
            $condition['category_id'] = $category->id;
        }
        $products = $this->productRepository->paginate(conditions: $condition);
        return view('website.product.index', compact('products'));
    }

    public function show(Product $product)
    {
        try {
            $userId = Auth::user()->id;
            $itemCount = $this->cartService->getProductCountInCart($userId, $product->id);
            return view('website.product.show', compact('product', 'itemCount'));
        } catch (\Exception $e) {
            logger()->error($e);
            alert()->error($e->getMessage());
            return redirect()->back();
        }
    }
}
