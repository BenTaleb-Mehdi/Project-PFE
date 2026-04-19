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
        $clientId = $this->route('client');
        $client = \App\Models\Client::findOrFail($clientId);
        $userId = $client->user_id;

        return [
            'name' => ['string', 'max:255'],
            'email' => ['string', 'email', 'max:255', 'unique:users,email,'.$userId.',id'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'target_goal' => ['nullable', 'numeric', 'min:0'],
            'current_weight' => ['nullable', 'numeric', 'min:0'],
            'height' => ['nullable', 'numeric', 'min:0'],
            'status' => ['string', 'in:active,inactive,pending'],
        ];
    }
}
