<?php

namespace App;

enum DiscountType: string
{
    case Percentage = 'percentage';
    case Fixed = 'fixed';
}
