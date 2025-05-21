<?php

namespace App\Services\Builders\Order;

use App\Models\Order;

interface OrderBuilderInterface
{
    public function setDiscount(string $code = null);

    public function setCart($userId);

    public function calculateTotalAmount($cartId);

    public function calculateDiscountAmount($totalAmount, $discountId = null);

    public function calculateSubTotalAmount($totalAmount, $discountAmount);

    public function setUser();

    public function setTrackingCode();

    public function setShippingAddress($address = null);

    public function storeOrder();

    public function build(): Order;
}
