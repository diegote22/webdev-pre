<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Para compatibilidad con vistas que usan 'name' directamente
            'name' => ['sometimes', 'string', 'max:255'],
            // En el flujo de estudiante usamos first_name/last_name, pero no son obligatorios aquí
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'title' => ['nullable', 'string', 'max:60'],
            'biography' => ['nullable', 'string', 'max:2000'],
            'language' => ['nullable', 'string', 'in:es,en,pt,fr'],
            'website' => ['nullable', 'url', 'max:255'],
            'facebook' => ['nullable', 'string', 'max:100'],
            'instagram' => ['nullable', 'string', 'max:100'],
            'linkedin' => ['nullable', 'string', 'max:255'],
            'tiktok' => ['nullable', 'string', 'max:100'],
            'twitter' => ['nullable', 'string', 'max:100'],
            'youtube' => ['nullable', 'string', 'max:100'],
        ];
    }
    
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Combine first_name and last_name into name for compatibility
        if ($this->has('first_name') && $this->has('last_name')) {
            $this->merge([
                'name' => trim($this->first_name . ' ' . $this->last_name),
            ]);
        }
    }
}
