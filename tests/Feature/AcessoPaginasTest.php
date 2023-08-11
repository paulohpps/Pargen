<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class AcessoPaginasTest extends TestCase
{
    public function testeNaoPodeAcessarDashboardSemLogin(): void
    {
        $response = $this->get('/dashboard/home');

        $response->assertStatus(302);
        $response->assertRedirectToRoute('login');
    }
    public function testePodeAcessarHome(): void
    {
        $usuario = $this->getUsuario();
        $response = $this->actingAs($usuario)->get('/dashboard/home');

        $response->assertStatus(200);
        $response->assertInertia(fn (AssertableInertia  $page) => $page->component('Dashboard/Home/Home'));
    }

    public function testePodeAcessarPaginaAnalises(): void
    {
        $usuario = $this->getUsuario();
        $response = $this->actingAs($usuario)->get('/dashboard/analises');

        $response->assertStatus(200);
    }
}
