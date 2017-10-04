<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateJobOfferRequest extends FormRequest
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
            'special_role_id' => 'required',
            'job_count' => 'required',
            'description' => 'required|max:255|min:10',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Le titre de l\'offre d\'emploi est nécessaire',
            'special_role_id.required' => 'Le nom du poste est nécessaire',
            'job_count.required' => 'Le nombre de postes disponibles est nécessaire',
            'description.required' => 'La description du poste est nécessaire',
            'description.max' => 'La description de l\'offre d\'emploi doit être au maximum 255 caractères',
            'description.min' => 'La description de l\'offre d\'emploi doit être au minimum 10 caractères',
        ];
    }
}

