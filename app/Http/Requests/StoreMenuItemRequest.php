<?php

namespace App\Http\Requests;

use App\Enums\MenuCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreMenuItemRequest extends FormRequest
{
    /**
     * En un escenario real esto validaría permisos (p. ej. rol "admin" o "gerente").
     * Se deja en true porque la autorización no es objeto de esta actividad.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:150'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'min:0', 'max:9999.99'],
            'category' => ['required', 'string', Rule::in(MenuCategory::values())],
            'image_url' => ['nullable', 'url', 'max:2048'],
            'available' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del platillo es obligatorio.',
            'name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un número.',
            'price.min' => 'El precio no puede ser negativo.',
            'category.required' => 'La categoría es obligatoria.',
            'category.in' => 'La categoría debe ser una de: ' . implode(', ', MenuCategory::values()),
            'image_url.url' => 'La URL de la imagen no es válida.',
        ];
    }

    /**
     * Respuesta JSON uniforme cuando la validación falla (útil para consumidores de la API).
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Los datos enviados no son válidos.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
