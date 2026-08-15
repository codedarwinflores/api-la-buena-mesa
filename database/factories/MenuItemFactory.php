<?php

namespace Database\Factories;

use App\Enums\MenuCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => ucfirst($this->faker->words(3, true)),
            'description' => $this->faker->sentence(12),
            'price' => $this->faker->randomFloat(2, 3, 45),
            'category' => $this->faker->randomElement(MenuCategory::values()),
            'image_url' => $this->faker->imageUrl(640, 480, 'food'),
            'available' => $this->faker->boolean(85),
        ];
    }
}
