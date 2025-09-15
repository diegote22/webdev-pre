<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'name' => ['nullable', 'string', 'max:255'], // Campo generado automáticamente
            'title' => ['nullable', 'string', 'max:60'],
            'biography' => ['nullable', 'string', 'max:2000'],
            'language' => ['required', 'string', 'in:es,en,pt,fr'],
            'website' => ['nullable', 'url', 'max:255'],
            'facebook' => ['nullable', 'string', 'max:100'],
            'instagram' => ['nullable', 'string', 'max:100'],
            'linkedin' => ['nullable', 'string', 'max:255'],
            'tiktok' => ['nullable', 'string', 'max:100'],
            'twitter' => ['nullable', 'string', 'max:100'],
            'youtube' => ['nullable', 'string', 'max:100'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'], // 2MB máximo
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'El nombre es obligatorio.',
            'first_name.max' => 'El nombre no puede tener más de 50 caracteres.',
            'last_name.required' => 'Los apellidos son obligatorios.',
            'last_name.max' => 'Los apellidos no pueden tener más de 50 caracteres.',
            'title.max' => 'El título no puede tener más de 60 caracteres.',
            'biography.max' => 'La biografía no puede tener más de 2000 caracteres.',
            'language.required' => 'El idioma es obligatorio.',
            'language.in' => 'El idioma seleccionado no es válido.',
            'website.url' => 'La página web debe ser una URL válida.',
            'website.max' => 'La página web no puede tener más de 255 caracteres.',
            'facebook.max' => 'El usuario de Facebook no puede tener más de 100 caracteres.',
            'instagram.max' => 'El usuario de Instagram no puede tener más de 100 caracteres.',
            'linkedin.max' => 'La URL de LinkedIn no puede tener más de 255 caracteres.',
            'tiktok.max' => 'El usuario de TikTok no puede tener más de 100 caracteres.',
            'twitter.max' => 'El usuario de X no puede tener más de 100 caracteres.',
            'youtube.max' => 'El usuario de YouTube no puede tener más de 100 caracteres.',
            'avatar.image' => 'El archivo debe ser una imagen.',
            'avatar.mimes' => 'La imagen debe ser de tipo: jpeg, jpg, png.',
            'avatar.max' => 'La imagen no puede pesar más de 2MB.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Combinar first_name y last_name en name
        if ($this->has('first_name') && $this->has('last_name')) {
            $this->merge([
                'name' => trim($this->first_name . ' ' . $this->last_name)
            ]);
        }
    }
}
