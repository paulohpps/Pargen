<?php

namespace App\Console\Commands\Commands\Usuario;

use App\Enums\Usuario\TipoUsuario;
use App\Models\Usuario;
use Illuminate\Console\Command;

class UsuarioAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'usuario:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para tornar um usuário administrador';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $username = $this->ask('Qual o nome de usuário?');
        $usuario = Usuario::where('username', $username)->first();

        if (!$usuario) {
            $this->error('Usuário não encontrado!');
            return;
        }

        if($usuario->tipo_usuario === TipoUsuario::Admin) {
            $this->error('Usuário já é administrador!');
            return;
        }

        $usuario->tipo_usuario = TipoUsuario::Admin;
        $usuario->save();

        $this->info('Usuário configurado como administrador com sucesso!');
    }
}
