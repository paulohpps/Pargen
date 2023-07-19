<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\Auth\LoginRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function index()
    {
        return Inertia::render('Home/Login');
    }

    public function login(LoginRequest $request)
    {
        $request->autenticar();
        $request->session()->regenerate();
        return redirect()->route('dashboard.home')
            ->with('mensagem', [
                'tipo' => 'success',
                'class' => 'text-success',
                'conteudo' => 'Login efetuado com sucesso!'
            ]);
    }
}
