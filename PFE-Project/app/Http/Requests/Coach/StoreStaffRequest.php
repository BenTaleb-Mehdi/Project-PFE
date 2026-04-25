<?php

namespace App\Http\Requests\Coach;

use Illuminate\Foundation\Http\FormRequest;

class StoreStaffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'             => ['required', 'string', 'max:255'],
            'email'            => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'legacy_specialty' => ['nullable', 'string', 'max:255'],
            'specialties'      => ['required', 'array'],
            'specialties.*'    => ['exists:specialties,id'],
            'phone_number'     => ['nullable', 'string', 'max:20'],
            'bio'              => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'IDENTITY_CONFLICT: This email is already registered in the team.',
        ];
    }
}
