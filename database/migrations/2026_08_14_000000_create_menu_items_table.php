<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración.
     */
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->string('category', 50);
            $table->string('image_url')->nullable();
            $table->boolean('available')->default(true);
            $table->timestamps();

            // Índices para optimizar consultas frecuentes (filtro por categoría/disponibilidad)
            $table->index('category');
            $table->index('available');
        });
    }

    /**
     * Revierte la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
