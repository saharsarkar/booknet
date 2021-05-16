<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'bail | min:5 | max:100',
            'description' => 'bail | min:5 | max: 255',
            'year' => 'bail | size:4 | numeric',
            'pdf_file' => 'mimes:pdf'
        ];
    }
}
