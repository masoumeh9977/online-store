<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MyController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('website.my.profile', compact('user'));
    }

    public function orders()
    {
        return view('website.my.order');
    }
}
