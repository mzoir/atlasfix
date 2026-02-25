<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateArtisanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // we will check role inside controller
    }

    public function rules(): array
    {
        $userId = $this->user()?->id;

        return [
            // account
            'email' => ['sometimes','email','max:180', Rule::unique('users','email')->ignore($userId)],
            'phone' => ['sometimes','string','max:30'],

            // password update (optional)
            'password' => ['sometimes','nullable','string','min:8','confirmed'],

            // profile
            'nom_complet' => ['sometimes','string','max:160'],
            'date_naissance' => ['sometimes','nullable','date'],
            'ville' => ['sometimes','nullable','string','max:120'],
            'adresse' => ['sometimes','nullable','string','max:255'],
            'diplome' => ['sometimes','nullable','string','max:255'],
            'description' => ['sometimes','nullable','string','max:2000'],

            // services
            'service_principal_id' => ['sometimes','nullable','integer','exists:services,id'],
            'service_ids' => ['sometimes','array'],
            'service_ids.*' => ['integer','exists:services,id'],
            'new_service_name' => ['sometimes','nullable','string','max:120'],

            // image
            'image' => ['sometimes','nullable','file','image','max:4096'],
        ];
    }
}
