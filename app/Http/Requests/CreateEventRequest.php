<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
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
            'special_role_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'begin.required' => 'La date de début est nécessaire',
            'end.required' => 'La date de fin est nécessaire',
            'special_role_id.required' => 'Le poste auquel assigner la tâche est nécessaire',
        ];
    }
}
