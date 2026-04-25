<?php

namespace App\Http\Requests\Coach;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => ['required', 'exists:clients,id'],
            'amount'    => ['required', 'numeric', 'min:0'],
            'date'      => ['required', 'date'],
            'status'    => ['required', 'in:paid,pending'],
        ];
    }

    public function messages(): array
    {
        return [
            'client_id.exists' => 'CLIENT_NOT_FOUND: Trace ID mapping failed.',
            'status.in'       => 'INVALID_STATUS: Payment must be marked as Paid or Pending.',
        ];
    }
}
