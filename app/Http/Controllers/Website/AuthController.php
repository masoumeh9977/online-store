<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Auth\LoginRequest;
use App\Http\Requests\Website\Auth\SignupRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginIndex()
    {
        return view('website.auth.login');
    }

    public function login(LoginRequest $request)
    {
        try {
            $user = User::whereEmail($request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                alert()->error('error', 'invalid email or password!');
                return redirect()->back();
            }

            if (!$user->hasRole('customer')) {
                alert()->error('Error', "You don't have the valid permission!");
                return redirect()->back();
            }
            Auth::login($user);
            alert()->success('Success', 'Logged in successfully!');
            return redirect()->route('website.index');

        } catch (\Exception $e) {
            logger()->error($e);
            alert()->error('Error', 'Something went wrong, please try again later.');
            return redirect()->back();
        }
    }

    public function logout()
    {
        try {
            if (Auth::user()) {
                Auth::logout();
                alert()->success('Success', 'Logged out successfully!');
            }
            return redirect()->route('website.index');

        } catch (\Exception $e) {
            logger()->error($e);
            alert()->error('Error', 'Something went wrong, please try again later.');
            return redirect()->back();
        }
    }

    public function signupIndex()
    {
        return view('website.auth.signup');
    }

    public function signup(SignupRequest $request)
    {
        try {
            $service = new UserService();
            $user = $service->createCustomer($request->all());
            Auth::login($user);
            alert()->success('Success', 'Signup successfully!');
            return redirect()->route('website.index');

        } catch (\Exception $e) {
            logger()->error($e);
            alert()->error('Error', 'Something went wrong, please try again later.');
            return redirect()->back();
        }
    }
}
