<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModifyCompanyRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'required',
            'telephone' => 'required',
            'email' => 'required',
            'ville' => 'required',
            'adresse' => 'required',
            'zipcode' => 'required',
            'pays' => 'required',
            'company_type_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Le nom de la compagnie est nécessaire',
            'name.unique' => 'Le nom de la compagnie est déjà pris',
            'telephone.unique' => 'Le numéro de téléphone de la compagnie est déjà pris',
            'email.unique' => 'L\'adresse courriel de la compagnie est déjà prise',
            'description.required' => 'La description de la compagnie est nécessaire',
            'telephone.required' => 'Le téléphone de la compagnie est nécessaire',
            'email.required' => 'L\'adresse courriel de la compagnie est nécessaire',
            'ville.required' => 'La ville de la compagnie est nécessaire',
            'adresse.required' => 'L\'adresse de la compagnie est nécessaire',
            'zipcode.required' => 'Le code postal de la compagnie est nécessaire',
            'pays.required' => 'Le pays de la compagnie est nécessaire',
            'company_type_id.required' => 'Le type de la compagnie est nécessaire',
        ];
    }
}
