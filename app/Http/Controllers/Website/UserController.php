<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\User\UpdateUserAddressRequest;
use App\Http\Requests\Website\User\UpdateUserPasswordRequest;
use App\Http\Requests\Website\User\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function updateUser(UpdateUserRequest $request)
    {
        try {
            $service = new UserService();
            $service->updateUser(Auth::user(), $request->all());
            alert()->success('Success', 'Updated successfully!');
            return redirect()->back();

        } catch (\Exception $e) {
            logger()->error($e);
            alert()->error('Error', 'Something went wrong, please try again later.');
            return redirect()->back();
        }
    }

    public function resetPassword(UpdateUserPasswordRequest $request)
    {
        try {
            $service = new UserService();

            if ($service->resetPassword(Auth::user(), $request->input('old_password'), $request->input('new_password'))) {
                alert()->success('Success', 'Updated successfully!');
            }
            return redirect()->back();

        } catch (\Exception $e) {
            logger()->error($e);
            alert()->error('Error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function resetAddress(UpdateUserAddressRequest $request)
    {
        try {
            $service = new UserService();
            $service->updateUser(Auth::user(), $request->all());
            alert()->success('Success', 'Updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            logger()->error($e);
            alert()->error('Error', 'Something went wrong, please try again later.');
            return redirect()->back();
        }
    }
}
