<?php

namespace Tests\Feature;

use App\Enums\Usuario\TipoUsuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Nette\Utils\Random;
use Tests\TestCase;

class UsuarioTest extends TestCase
{
    public function testPodeAcessarUsuario(): void
    {
        $response = $this->actingAs($this->getAdmin())
            ->get('/dashboard/usuarios');

        $response->assertStatus(200);
    }

    public function testPodeCriarUsuario(): void
    {
        $response = $this->actingAs($this->getUsuario())
            ->post('/dashboard/usuarios/criar', [
                'username' => 'testeUsuario',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'tipo_usuario' => TipoUsuario::Usuario->value,
            ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('usuarios', [
            'username' => 'testeUsuario',
            'tipo_usuario' => TipoUsuario::Usuario->value,
        ]);
    }

    public function testPodeEditarUsuario(): void
    {
        $usuario = $this->getUsuario();
        $novoNome = Random::generate(10);

        $response = $this->actingAs($this->getUsuario())
            ->post("/dashboard/usuarios/editar/{$usuario->id}", [
                'username' => $novoNome,
                'tipo_usuario' => TipoUsuario::Usuario->value,
            ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('usuarios', [
            'username' => $novoNome,
            'tipo_usuario' => TipoUsuario::Usuario->value,
        ]);
    }

    public function testPodeExcluirUsuario(): void
    {
        $usuario = $this->getUsuario();

        $response = $this->actingAs($this->getUsuario())
            ->get("/dashboard/usuarios/excluir/{$usuario->id}");

        $response->assertStatus(302);

        $this->assertDatabaseMissing('usuarios', [
            'id' => $usuario->id,
        ]);
    }
}
