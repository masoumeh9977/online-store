<?php

namespace App\Services;


use App\Models\Product;
use App\Models\User;

class UserService
{
    public function createCustomer(array $data)
    {
        $user = User::create($data);
        $user->assignRole('customer');
        return $user->refresh();
    }
}
