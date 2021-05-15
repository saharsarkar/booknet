<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'name' => 'bail | required | string | min:3',
            'username' => 'bail | required | min:3 | max:15 | unique:users',
            'email' => 'bail | required | email | max:30',
            'password' => 'bail | required | min:5 | confirmed',
        ];
    }
}
