<?php

namespace App\Http\Requests\Website\User;

use App\Http\Requests\BaseRequest;

class UpdateUserPasswordRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'old_password' => ['required', 'string', 'min:4'],
            'new_password' => ['required', 'string', 'min:4', 'different:old_password'],
            'confirm_password' => ['required', 'string', 'min:4', 'same:new_password']
        ];
    }
}
