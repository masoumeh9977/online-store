<?php

namespace App\Http\Requests\Website\Auth;

use App\Http\Requests\BaseRequest;

class SignupRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:4'],
            'agreement' => ['required', 'accepted']
        ];
    }
}
