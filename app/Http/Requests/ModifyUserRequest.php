<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModifyUserRequest extends FormRequest
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
            'email' => 'required',
            'phone_number' => 'required',
            'first_name' => 'required',
            'last_name' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'L\'adresse courriel est nécessaire',
            'phone_number.unique' => 'Le numéro de téléphone est nécessaire',
            'first_name.required' => 'Le prénom est nécessaire',
            'last_name.required' => 'Le nom de famille est nécessaire'
        ];
    }
}
