<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvolutionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'weight'      => ['required', 'numeric', 'min:30', 'max:300'],
            'photos'      => ['nullable', 'array', 'max:5'], // Max 5 photos
            'photos.*'    => ['image', 'mimes:jpeg,png,jpg', 'max:5120'], // Max 5MB per image
            'recorded_at' => ['required', 'date', 'before_or_equal:today'],
        ];
    }

    public function messages(): array
    {
        return [
            'weight.required' => 'Weight mapping failed // Requirement_Not_Met.',
            'photos.array'    => 'FILE_ERROR: Invalid upload format.',
            'photos.*.image'  => 'FILE_ERROR: Invalid image format (JPEG/PNG only).',
        ];
    }

}
