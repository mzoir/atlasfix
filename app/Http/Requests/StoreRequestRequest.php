<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service_name'    => ['required', 'string', 'max:100'],
            'service_type'    => ['nullable', 'string', 'max:100'],
            'description'     => ['required', 'string', 'max:250'],
            'ville'           => ['required', 'string', 'max:100'],
            'address'         => ['nullable', 'string', 'max:255'],
            'additional_info' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'service_name.required' => 'Le service est obligatoire.',
            'description.required'  => 'La description est obligatoire.',
            'description.max'       => 'La description ne peut pas dépasser 250 caractères.',
            'ville.required'        => 'La ville est obligatoire.',
        ];
    }
}