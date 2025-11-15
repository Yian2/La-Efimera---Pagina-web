<?php

namespace Database\Factories;

use App\Models\Pedido;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class PedidoFactory extends Factory
{
    protected $model = Pedido::class;

    public function definition(): array
    {
        return [
            'usuario_id'     => Usuario::factory()->cliente(),
            'estado'         => $this->faker->randomElement(['pendiente','preparando','listo','entregado','cancelado']),
            'es_para_llevar' => $this->faker->boolean(),
            'total'          => $this->faker->randomFloat(2, 5, 60),
            'fecha_creacion' => now(),
        ];
    }
}
