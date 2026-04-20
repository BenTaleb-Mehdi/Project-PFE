<?php

namespace App\Http\Requests\Coach;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Assuming Coach access is handled by middleware
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'target_goal' => ['nullable', 'numeric', 'min:0'],
            'current_weight' => ['nullable', 'numeric', 'min:0'],
            'height' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'in:active,inactive,pending'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'IDENTITY_CONFLICT: This email already exists in the registry.',
            'status.in' => 'INVALID_STATE: Status must be active, inactive, or pending.',
        ];
    }
}
