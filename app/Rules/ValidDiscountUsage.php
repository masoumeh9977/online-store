<?php

namespace App\Rules;

use App\Models\Discount;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidDiscountUsage implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $discount = Discount::whereCode($value)->first();
        if (!$discount) {
            $fail('The selected discount is invalid.');
            return;
        }
        if ($discount->used_count >= $discount->max_usage) {
            $fail("The discount code '{$discount->code}' has reached its maximum usage limit.");
        }
        if (!$discount->is_active) {
            $fail("The discount code '{$discount->code}' is inactive.");
        }
        if ($discount->expires_at && now()->greaterThan($discount->expires_at)) {
            $fail("The discount code '{$discount->code}' has expired.");
        }
    }
}
