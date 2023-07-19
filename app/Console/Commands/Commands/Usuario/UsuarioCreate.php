<?php

namespace App\Console\Commands\Commands\Usuario;

use App\Enums\Usuario\TipoUsuario;
use App\Models\Usuario;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class UsuarioCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'usuario:create {--admin : Crie um usuario administrador}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para criar um usuário';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $username = $this->ask('Qual o nome de usuário?');
        $password = $this->secret('Qual a senha?');

        $tipo_usuario = TipoUsuario::Usuario;

        if ($this->option('admin')) {
            $tipo_usuario = TipoUsuario::Admin;
        }

        $usuario = new Usuario([
            'username' => $username,
            'tipo_usuario' => $tipo_usuario,
        ]);

        $usuario->password = Hash::make($password);
        $usuario->save();

        $this->info('Usuário criado com sucesso!');
    }
}
