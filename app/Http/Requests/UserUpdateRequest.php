<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
            'name' => 'bail | string | min:3',
            'username' => 'bail | min:3 | max:15 | unique:users',
            'email' => 'bail | email | max:30',
            'role' => ['string', Rule::in(['admin', 'user'])],
        ];
    }
}
