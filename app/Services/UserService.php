<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserService
{
    public function createCustomer(array $data)
    {
        $user = User::create($data);
        $user->assignRole('customer');
        return $user->refresh();
    }

    public function resetPassword($user, $oldPass, $newPass): bool
    {
        if (!Hash::check($oldPass, $user->password)) {
            throw ValidationException::withMessages([
                'old_password' => 'Your old password is incorrect.',
            ]);
        }

        $user->password = $newPass;
        $user->save();
        return true;
    }

    public function updateUser($user, $data)
    {
        return $user->update($data);
    }
}
