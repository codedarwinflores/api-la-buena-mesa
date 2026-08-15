<?php

namespace App\Http\Resources;

use App\Enums\MenuCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemResource extends JsonResource
{
    /**
     * Transforma el recurso en un arreglo, desacoplando la
     * estructura de la respuesta JSON del esquema de la base de datos.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => (float) $this->price,
            'category' => $this->category,
            'category_label' => MenuCategory::tryFrom($this->category)?->label() ?? $this->category,
            'image_url' => $this->image_url,
            'available' => (bool) $this->available,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
