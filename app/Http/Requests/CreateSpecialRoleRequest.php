<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSpecialRoleRequest extends FormRequest
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
            'skills' => 'required',
            'name' => 'required|min:3',
            'description' => 'required|min:10|max:255',
            'roles' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'skills.required' => 'Vous devez choisir au moins une compétence',
            'name.required' => 'Le nom du poste est nécessaire',
            'description.required' => 'La description du poste est nécessaire',
            'roles.required' => 'Vous devez choisir au moins un rôle',
            'name.min' => 'Le nom du poste doit au moins avoir 3 caractères',
            'description.min' => 'La description du poste doit au moins avoir 3 caractères',
            'description.max' => 'La description du poste doit au maximum avoir 255 caractères',
        ];
    }
}
