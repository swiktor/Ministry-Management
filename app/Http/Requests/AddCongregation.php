<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCongregation extends FormRequest
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
            'name' => 'required|alpha_dash|min:3',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Pole wymagane',
            'name.alpha_dash' => 'Możesz wpisać tylko litery i myślnik',
            'name.required' => 'Pole wymagane',
        ];
    }
}
