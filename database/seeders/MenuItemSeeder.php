<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Ejecuta el seeder: platillos reales de "La Buena Mesa"
     * más registros aleatorios generados con la factory.
     */
    public function run(): void
    {
        $items = [
            [
                'name' => 'Carpaccio de Res Trufado',
                'description' => 'Finas láminas de res, aceite de trufa, parmesano y rúcula.',
                'price' => 8.50,
                'category' => 'entrada',
                'image_url' => 'https://picsum.photos/seed/carpaccio/640/480',
                'available' => true,
            ],
            [
                'name' => 'Ceviche Fusión Asiática',
                'description' => 'Pescado blanco, leche de tigre con toque de jengibre y cilantro.',
                'price' => 9.75,
                'category' => 'entrada',
                'image_url' => 'https://picsum.photos/seed/ceviche/640/480',
                'available' => true,
            ],
            [
                'name' => 'Risotto de Hongos Silvestres',
                'description' => 'Arroz arborio cremoso, mezcla de hongos y aceite de trufa negra.',
                'price' => 16.00,
                'category' => 'plato_fuerte',
                'image_url' => 'https://picsum.photos/seed/risotto/640/480',
                'available' => true,
            ],
            [
                'name' => 'Short Rib Glaseado en Salsa de Tamarindo',
                'description' => 'Costilla braseada 12 horas, glaseado agridulce, puré de camote.',
                'price' => 22.50,
                'category' => 'plato_fuerte',
                'image_url' => 'https://picsum.photos/seed/shortrib/640/480',
                'available' => true,
            ],
            [
                'name' => 'Salmón Teriyaki con Quinoa',
                'description' => 'Salmón a la plancha, glaseado teriyaki casero, quinoa tricolor.',
                'price' => 19.00,
                'category' => 'plato_fuerte',
                'image_url' => 'https://picsum.photos/seed/salmon/640/480',
                'available' => false,
            ],
            [
                'name' => 'Puré de Papa Trufado',
                'description' => 'Puré cremoso con mantequilla, crème fraîche y aceite de trufa.',
                'price' => 5.00,
                'category' => 'acompanamiento',
                'image_url' => 'https://picsum.photos/seed/pure/640/480',
                'available' => true,
            ],
            [
                'name' => 'Tarta de Chocolate y Maracuyá',
                'description' => 'Ganache de chocolate 70%, coulis de maracuyá, tierra de cacao.',
                'price' => 7.50,
                'category' => 'postre',
                'image_url' => 'https://picsum.photos/seed/tarta/640/480',
                'available' => true,
            ],
            [
                'name' => 'Cheesecake de Maracuyá',
                'description' => 'Base de galleta, queso crema horneado, glaseado de maracuyá.',
                'price' => 6.75,
                'category' => 'postre',
                'image_url' => 'https://picsum.photos/seed/cheesecake/640/480',
                'available' => true,
            ],
            [
                'name' => 'Coctel de Autor "Fusión Tropical"',
                'description' => 'Ron añejo, maracuyá, jengibre y albahaca fresca.',
                'price' => 8.00,
                'category' => 'bebida',
                'image_url' => 'https://picsum.photos/seed/coctel/640/480',
                'available' => true,
            ],
            [
                'name' => 'Limonada de Hierbabuena y Jengibre',
                'description' => 'Limonada natural con hierbabuena fresca y un toque de jengibre.',
                'price' => 3.50,
                'category' => 'bebida',
                'image_url' => 'https://picsum.photos/seed/limonada/640/480',
                'available' => true,
            ],
        ];

        foreach ($items as $item) {
            MenuItem::create($item);
        }

        // Registros adicionales aleatorios para pruebas de paginación/filtrado
        MenuItem::factory()->count(15)->create();
    }
}
