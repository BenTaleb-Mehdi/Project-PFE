<?php

namespace App\Http\Requests\Coach;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('client'); // Assuming the route parameter is 'client'

        return [
            'name' => ['string', 'max:255'],
            'email' => ['string', 'email', 'max:255', 'unique:users,email,'.$id.',id'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'target_goal' => ['nullable', 'numeric', 'min:0'],
            'current_weight' => ['nullable', 'numeric', 'min:0'],
            'height' => ['nullable', 'numeric', 'min:0'],
            'status' => ['string', 'in:active,inactive,pending'],
        ];
    }
}
