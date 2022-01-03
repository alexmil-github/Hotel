<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiRequest;

class RegisterUserRequest extends ApiRequest
{

    public function rules()
    {
        return [
            'name' => 'required|string',
            'surname' => 'string',
            'patronymic' => 'string',
            'login' => 'required|string|unique:users',
            'password' => 'required|string',
            'photo_file' => 'image|mimes:jpg,jpeg,png',
        ];
    }
}
