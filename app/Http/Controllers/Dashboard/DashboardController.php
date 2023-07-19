<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\Usuario\TipoUsuario;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Usuarios\CriarUsuarioRequest;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function home()
    {
        return Inertia::render('Dashboard/Home/Home');
    }
    public function usuarios()
    {
        $usuarios = Usuario::all();
        $tiposUsuario = TipoUsuario::toArray();
        return Inertia::render('Dashboard/Configuracoes/Usuarios/Listagem', compact('usuarios', 'tiposUsuario'));
    }

    public function criarUsuario(CriarUsuarioRequest $request)
    {
        $usuario = new Usuario($request->only([
            'username',
            'tipo_usuario',
        ]));

        $usuario->password = Hash::make($request->password);
        $usuario->save();

        return redirect()->route('dashboard.usuarios')
            ->with('mensagem', [
                'tipo' => 'success',
                'class' => 'text-success',
                'conteudo' => 'Usuario criado com sucesso!'
            ]);
    }

    public function editarUsuario(int $id, Request $request)
    {
        $usuario = Usuario::find($id);
        $usuario->update([
            ...$request->all(),
        ]);

        return redirect()->route('dashboard.usuarios')
            ->with('mensagem', [
                'tipo' => 'success',
                'class' => 'text-success',
                'conteudo' => 'Usuario atualizado com sucesso!'
            ]);
    }

    public function excluirUsuario(int $id)
    {
        Usuario::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Usuário excluído com sucesso!')
            ->with('mensagem', [
                'tipo' => 'success',
                'class' => 'text-success',
                'conteudo' => 'Usuario excluído com sucesso!'
            ]);;
    }

    public function getUsuario($id)
    {
        $usuario = Usuario::find($id);
        return response()->json($usuario);
    }
}
