<?php

namespace App\Http\Controllers\Dashboard\Geral;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Funcionarios\FuncionarioRequest;
use App\Models\Gerais\Funcionario;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FuncionarioController extends Controller
{
    public function funcionarios()
    {
        $funcionarios = Funcionario::orderBy('nome')->paginate(10);
        return Inertia::render('Dashboard/Gerais/Funcionarios/Listagem', compact('funcionarios'));
    }

    public function criarFuncionario(FuncionarioRequest $request)
    {
        Funcionario::create($request->all());
        return redirect()->back();
    }

    public function funcionarioAcessar(int $id)
    {
        $funcionario = Funcionario::find($id);
        return Inertia::render('Dashboard/Gerais/Funcionarios/FuncionarioInformacoes', compact('funcionario'));
    }

    public function editarFuncionario(int $id)
    {
        $funcionario = Funcionario::find($id);
        return inertia('Dashboard/Gerais/Funcionarios/Editar', compact('funcionario'));
    }

    public function salvarFuncionario(FuncionarioRequest $request, int $id)
    {
        $funcionario = Funcionario::find($id);
        $funcionario->update($request->all());
        return redirect('/dashboard/funcionarios');
    }

    public function excluirFuncionario(int $id)
    {
        $funcionario = Funcionario::find($id);
        $funcionario->delete();
        return redirect()->back();
    }

    public function consultar()
    {
        $funcionarios = Funcionario::all();
        return response()->json($funcionarios);
    }
}
