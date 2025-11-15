<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public function definition(): array
    {
        return [
            'nombre'     => $this->faker->name(),
            'correo'     => $this->faker->unique()->safeEmail(),
            'contrasena' => Hash::make('123456'), // senzill per login de proves
            'rol'        => $this->faker->randomElement(['cliente','admin']),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn () => ['rol' => 'admin']);
    }

    public function cliente(): static
    {
        return $this->state(fn () => ['rol' => 'cliente']);
    }
}
