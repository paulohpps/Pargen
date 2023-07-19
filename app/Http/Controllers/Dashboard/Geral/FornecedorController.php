<?php

namespace App\Http\Controllers\Dashboard\Geral;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Fornecedores\FornecedorRequest;
use App\Models\Gerais\Fornecedor;
use Inertia\Inertia;

class FornecedorController extends Controller
{
    public function fornecedores()
    {
        $fornecedores = Fornecedor::paginate(10);
        return Inertia::render('Dashboard/Gerais/Fornecedores/Listagem', compact('fornecedores'));
    }

    public function criarFornecedor(FornecedorRequest $request)
    {
        Fornecedor::create($request->all());
        return redirect()->route('dashboard.fornecedores')
            ->with('mensagem', [
                'tipo' => 'success',
                'class' => 'text-success',
                'conteudo' => 'Fornecedor criado com sucesso!'
            ]);
    }

    public function editarFornecedor($id)
    {
        $fornecedor = Fornecedor::find($id);
        return Inertia::render('Dashboard/Gerais/Fornecedores/Editar', compact('fornecedor'));
    }

    public function salvarFornecedor(FornecedorRequest $request, $id)
    {
        $fornecedor = Fornecedor::find($id);
        $fornecedor->update($request->all());
        return redirect()->route('dashboard.fornecedores')
            ->with('mensagem', [
                'tipo' => 'success',
                'class' => 'text-success',
                'conteudo' => 'Fornecedor atualizado com sucesso!'
            ]);
    }

    public function excluirFornecedor($id)
    {
        $fornecedor = Fornecedor::find($id);
        $fornecedor->delete();
        return redirect()->route('dashboard.fornecedores')
            ->with('mensagem', [
                'tipo' => 'success',
                'class' => 'text-success',
                'conteudo' => 'Fornecedor excluído com sucesso!'
            ]);
    }

    public function consultar()
    {
        $fornecedores = Fornecedor::all();
        return response()->json($fornecedores);
    }
}
