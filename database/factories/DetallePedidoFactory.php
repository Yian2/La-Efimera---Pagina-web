<?php

namespace Database\Factories;

use App\Models\DetallePedido;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetallePedidoFactory extends Factory
{
    protected $model = DetallePedido::class;

    public function definition(): array
    {
        $cantidad = $this->faker->numberBetween(1, 3);
        $precio   = $this->faker->randomFloat(2, 2, 20);

        return [
            'pedido_id'          => Pedido::factory(),
            'producto_id'        => Producto::factory(),
            'cantidad'           => $cantidad,
            'precio_unitario'    => $precio,
            'subtotal'           => $cantidad * $precio,
            'fecha_creacion'     => now(),
            'fecha_actualizacion'=> now(),
        ];
    }
}
