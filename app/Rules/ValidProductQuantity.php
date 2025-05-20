<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidProductQuantity implements ValidationRule
{

    /**
     * Run the validation rule.
     *
     * @param \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Case 1: products.*.quantity structure
        if (preg_match('/products\.(\d+)\.quantity/', $attribute, $matches)) {
            $index = $matches[1];
            $productId = request("products.$index.id");
        } // Case 2: standalone quantity and product_id
        elseif ($attribute === 'quantity') {
            $productId = request('product_id');
        } // Unknown format
        else {
            $fail('Invalid quantity field structure.');
            return;
        }

        if (!$productId) {
            $fail("Missing product ID.");
            return;
        }
        $product = Product::find($productId);
        if (!$product) {
            $fail('Product Not Found!');
            return;
        }

        if (($product->quantity - $value) < 0) {
            $fail('The requested quantity exceeds available stock (' . $product->quantity . ').');
        }
    }
}
