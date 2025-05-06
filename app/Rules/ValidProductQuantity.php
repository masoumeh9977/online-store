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
        preg_match('/products\.(\d+)\.quantity/', $attribute, $matches);

        if (!isset($matches[1])) {
            $fail('Invalid product quantity structure.');
            return;
        }
        $index = $matches[1];
        $productId = request("products.$index.id");
        if (!$productId) {
            $fail("Missing product ID for item at index $index.");
            return;
        }
        $product = Product::find($productId);
        if (!$product) {
            $fail('Product Not Found!');
            return;
        }
        logger()->info('quantity: ' . $value . ' $product->quantity: '. $product->quantity);
        if (( $product->quantity - $value) < 0) {
            $fail('The requested quantity for product ID '.$productId. ' exceeds available stock ('.$product->quantity.').');
        }
    }
}
