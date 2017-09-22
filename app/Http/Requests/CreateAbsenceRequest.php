<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAbsenceRequest extends FormRequest
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
            'reason' => 'required|max:255|min:10',
        ];
    }

    public function messages()
    {
        return [
            'begin.required' => 'La date de début est nécessaire',
            'end.required' => 'La date de fin est nécessaire',
            'reason.required' => 'La raison de l\'absence est nécessaire',
            'reason.max' => 'La raison de l\'absence doit être au maximum 255 caractères',
            'reason.min' => 'La raison de l\'absence doit être au minimum 10 caractères',
        ];
    }
}