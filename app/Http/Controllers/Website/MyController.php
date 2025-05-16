<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\StoreOrderRequest;
use App\Http\Resources\BaseResource;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Support\Facades\Auth;

class MyController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('website.my.profile', compact('user'));
    }
}
