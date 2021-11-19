<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCoworker extends FormRequest
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
            'name' => 'required|string|min:3',
            'surname' => 'required|string|min:3',
            'congregation' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Pole wymagane',
            'name.string' => 'Możesz wpisać tylko litery',
            'name.required' => 'Pole wymagane',
            'surname.string' => 'Możesz wpisać tylko litery',
            'rate.min' => 'Minimalna ilość liter to: :min',
            'congregation.integer' => 'Wybierz poprawny zbór',
        ];
    }
}
