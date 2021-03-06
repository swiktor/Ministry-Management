<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditMinistry extends FormRequest
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
            'when' => 'required',
            'coworkers' => 'required|array',
            'ministry_id' => 'required|integer',
            'report_id' => 'required|integer',
            'hours' => 'required',
            'placements' => 'required|integer|min:0',
            'videos' => 'required|integer|min:0',
            'returns' => 'required|integer|min:0',
            'studies' => 'required|integer|min:0',

        ];
    }

    public function messages()
    {
        return [
            'min' => 'Minimalna ilość cyfr to: :min',
            'required' => 'To pole jest wymagane',
            'integer' => 'Możesz wpisać tylko liczbę',
            'array' => 'Parametr musi być tablicą',
        ];
    }
}
