<?php

namespace App\Http\Requests\Website\User;

use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = Auth::user();
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users,email,' . $user->email]
        ];
    }
}
