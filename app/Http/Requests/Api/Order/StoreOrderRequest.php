<?php

namespace App\Http\Requests\Api\Order;

use App\Rules\ValidDiscountUsage;
use App\Rules\ValidProductQuantity;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'discount_code' => ['nullable', 'string', 'exists:discounts,code', new ValidDiscountUsage()],
            'shipping_address' => ['nullable', 'string']
        ];
    }
}
