<?php

namespace App\Http\Requests;

use App\Enums\MenuCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateMenuItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas con "sometimes" para soportar tanto PUT (reemplazo completo)
     * como PATCH (actualización parcial) sin duplicar clases.
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'min:3', 'max:150'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['sometimes', 'required', 'numeric', 'min:0', 'max:9999.99'],
            'category' => ['sometimes', 'required', 'string', Rule::in(MenuCategory::values())],
            'image_url' => ['nullable', 'url', 'max:2048'],
            'available' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del platillo no puede quedar vacío.',
            'price.numeric' => 'El precio debe ser un número.',
            'price.min' => 'El precio no puede ser negativo.',
            'category.in' => 'La categoría debe ser una de: ' . implode(', ', MenuCategory::values()),
            'image_url.url' => 'La URL de la imagen no es válida.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Los datos enviados no son válidos.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
