<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required|min:8'
        ];
    }
}
