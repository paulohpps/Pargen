<?php

namespace Tests;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function getAdmin(): Usuario
    {
        return Usuario::factory()->admin()->create();
    }

    protected function getUsuario(): Usuario
    {
        return Usuario::factory()->create();
    }
}
