<?php

namespace App\Services\Builders\Order;

use App\Models\Order;

interface OrderBuilderInterface
{
    public function setUser();

    public function setTrackingCode();

    public function setProducts(array $products);

    public function setDiscount(string $code = null);

    public function setTotalAmount();

    public function build(): Order;
}
