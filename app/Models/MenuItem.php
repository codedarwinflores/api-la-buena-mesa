<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MenuItem extends Model
{
    use HasFactory;

    /**
     * Atributos asignables masivamente.
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'image_url',
        'available',
    ];

    /**
     * Casts de atributos.
     */
    protected $casts = [
        'price' => 'decimal:2',
        'available' => 'boolean',
    ];

    /**
     * Scope: filtra por categoría.
     * Uso: MenuItem::category('postre')->get();
     */
    public function scopeCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    /**
     * Scope: solo elementos disponibles.
     * Uso: MenuItem::available()->get();
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('available', true);
    }
}
