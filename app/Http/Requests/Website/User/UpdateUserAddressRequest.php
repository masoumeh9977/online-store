<?php

namespace App\Http\Requests\Website\User;

use App\Http\Requests\BaseRequest;

class UpdateUserAddressRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'address' => ['required', 'string'],
            'province_id' => ['nullable', 'exists:iran_provinces,id'],
            'city_id' => ['nullable', 'exists:iran_cities,id'],
        ];
    }
}
