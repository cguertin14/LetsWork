<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSkillRequest extends FormRequest
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
            'name' => 'required|min:3',
            'description' => 'required|max:255|min:10'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Le nom de la compétence est nécessaire.',
            'description.required' => 'La description de la compétence est nécessaire.',
            'name.min' => 'Le nom de la compétence doit avoir au moins 3 caractères.',
            'description.min' => 'La description de la compétence doit avoir au moins 10 caractères.',
            'description.max' => 'La description de la compétence doit avoir au maximum 255 caractères'
        ];
    }
}
