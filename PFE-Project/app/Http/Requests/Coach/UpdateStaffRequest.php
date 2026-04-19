<?php

namespace App\Http\Requests\Coach;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffRequest extends FormRequest
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
        $staffId = $this->route('team'); // Assuming the route parameter is 'team'
        $staff = \App\Models\Staff::find($staffId);
        $userId = $staff ? $staff->user_id : null;

        return [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $userId],
            'specialty' => ['required', 'string', 'max:255'],
            'bio'       => ['nullable', 'string', 'max:1000'],
        ];
    }
}
