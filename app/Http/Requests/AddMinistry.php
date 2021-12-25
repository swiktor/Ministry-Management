<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddMinistry extends FormRequest
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
            'type' => 'required|integer',
            'when' => 'required',
            'coworker' => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Pole wymagane',
            'integer' => 'Możesz wpisać tylko cyfry',
            'array' => 'Parametr musi być tablicą'
        ];
    }
}
