<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Conta\AlterarSenhaRequest;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class ContaController extends Controller
{
    public function home()
    {
        $usuario = auth()->user();
        return Inertia::render('Dashboard/Conta/Conta', compact('usuario'));
    }

    public function alterarSenha(AlterarSenhaRequest $request)
    {
        /** @var \App\Models\Usuario $usuario **/
        $usuario = auth()->user();
        $usuario->password = Hash::make($request->senha);
        $usuario->save();

        return redirect()->back()
            ->with('mensagem', [
                'tipo' => 'success',
                'class' => 'text-success',
                'conteudo' => 'Senha alterada com sucesso!'
            ]);
    }
}
