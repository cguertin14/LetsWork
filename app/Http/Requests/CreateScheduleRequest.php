<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateScheduleRequest extends FormRequest
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
            'begin' => 'required',
            'end' => 'required',
            'name' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'begin.required' => 'La date de début est nécessaire',
            'end.required' => 'La date de fin est nécessaire',
            'name.required' => 'Le nom de l\'horaire est nécessaire',
        ];
    }
}
