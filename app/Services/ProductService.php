<?php

namespace App\Services;


use App\Models\Product;

class ProductService
{
    public function getLatestItems($limit, $categoryId = null)
    {
        $products = Product::active()
            ->latest()
            ->limit($limit);
        if ($categoryId) {
            $products = $products->where('category_id', $categoryId);
        }
        return $products->get();
    }
}
