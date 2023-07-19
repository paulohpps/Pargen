<?php

namespace Database\Factories;

use App\Enums\Usuario\TipoUsuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => $this->faker->userName,
            'tipo_usuario' => TipoUsuario::Admin,
            'password' => Hash::make('password'),
        ];
    }

    public function admin(): mixed
    {
        return $this->state([
            'tipo_usuario' => TipoUsuario::Admin,
        ]);
    }

}
