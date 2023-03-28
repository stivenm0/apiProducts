<?php

namespace Database\Factories;

use App\Models\Products;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre'=> $this->faker->name,
            'descripcion'=> $this->faker->text(100),
            'precio'=> $this->faker->randomFloat(2,10,5000),
        ];
    }
}
