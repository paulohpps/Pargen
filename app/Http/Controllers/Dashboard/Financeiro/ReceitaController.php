<?php

namespace App\Http\Controllers\Dashboard\Financeiro;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Financeiro\ReceitaRequest;
use App\Models\Financeiro\Categorias\Categoria;
use App\Models\Financeiro\Receita;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReceitaController extends Controller
{
    public function receitas()
    {
        $receitas = Receita::with(['categoria', 'subcategoria'])->paginate(10);
        $categorias = Categoria::with('subcategorias')->get();

        return Inertia::render('Dashboard/Financeiro/Receitas/Listagem', compact('receitas', 'categorias'));
    }

    public function criar(ReceitaRequest $request)
    {
        Receita::create([
            ...$request->all(),
        ]);

        return redirect()->back()
            ->with('mensagem', [
                'tipo' => 'success',
                'class' => 'text-success',
                'conteudo' => 'Receita criada com sucesso!'
            ]);
    }

    public function editar(int $id)
    {
        $receita = Receita::with(['categoria', 'categoria.subcategorias', 'subcategoria'])->find($id);

        $categorias = Categoria::with('subcategorias')->get();
        return Inertia::render('Dashboard/Financeiro/Receitas/Editar', compact('receita', 'categorias'));
    }

    public function salvar(Request $request, int $id)
    {
        $receita = Receita::find($id);
        $receita->update($request->all());
        return redirect('/dashboard/financeiro/receitas')
            ->with('mensagem', [
                'tipo' => 'success',
                'class' => 'text-success',
                'conteudo' => 'Receita atualizada com sucesso!'
            ]);
    }

    public function excluir(int $id)
    {
        Receita::find($id)->delete();
        return redirect('/dashboard/financeiro/receitas')
            ->with('mensagem', [
                'tipo' => 'success',
                'class' => 'text-success',
                'conteudo' => 'Receita excluída com sucesso!'
            ]);
    }
}
