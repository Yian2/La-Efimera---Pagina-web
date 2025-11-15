<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    public function definition(): array
    {
        return [
            'nombre'      => $this->faker->unique()->words(2, true),
            'descripcion' => $this->faker->sentence(),
            'precio'      => $this->faker->randomFloat(2, 1, 20),
            'tipo'        => $this->faker->randomElement([
                'pizza_vermella','pizza_blanca','pizza_gourmet',
                'focaccia','lasanya','calzone','suplement',
                'amanida','pica_pica','postre','cafe','infusio','beguda','vi'
            ]),
            'activo'      => $this->faker->boolean(90),
        ];
    }
}
