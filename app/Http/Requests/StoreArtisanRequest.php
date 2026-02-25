<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArtisanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // public register
    }

    public function rules(): array
    {
        return [
            // account
            'email' => ['required','email','max:180','unique:users,email'],
            'phone' => ['required','string','max:30'],
            'password' => ['required','string','min:8','confirmed'],

            // profile
            'nom_complet' => ['required','string','max:160'],
            'date_naissance' => ['nullable','date'],
            'ville' => ['nullable','string','max:120'],
            'adresse' => ['nullable','string','max:255'],
            'diplome' => ['nullable','string','max:255'],
            'description' => ['nullable','string','max:2000'],

            // services
            'service_principal_id' => ['nullable','integer','exists:services,id'],
            'service_ids' => ['nullable','array'],
            'service_ids.*' => ['integer','exists:services,id'],
            'new_service_name' => ['nullable','string','max:120'],

            // image
            'image' => ['nullable','file','image','max:4096'], // 4MB
        ];
    }
}
