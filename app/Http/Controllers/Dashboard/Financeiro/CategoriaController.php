<?php

namespace App\Http\Controllers\Dashboard\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\Financeiro\Categorias\Categoria;
use App\Models\Financeiro\Categorias\Subcategoria;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoriaController extends Controller
{
    public function categorias()
    {
        $categorias = Categoria::with('subcategorias')->paginate(6);

        return Inertia::render('Dashboard/Financeiro/Categorias/Categorias', compact('categorias'));
    }

    public function criarCategoria(Request $request)
    {
        Categoria::create($request->all());

        return redirect()->back()
            ->with('mensagem', [
                'tipo' => 'success',
                'class' => 'text-success',
                'conteudo' => 'Categoria criada com sucesso!'
            ]);
    }

    public function criarSubcategoria(Request $request, ?int $categoria_id)
    {
        Subcategoria::create($request->all());

        return redirect()->back()
            ->with('mensagem', [
                'tipo' => 'success',
                'class' => 'text-success',
                'conteudo' => 'Subcategoria criada com sucesso!'
            ]);
    }

    public function editarCategoria(Request $request, int $categoria_id)
    {
        $categoria = Categoria::find($categoria_id);
        $categoria->nome = $request->nome;
        $categoria->save();

        return redirect()->back()
            ->with('mensagem', [
                'tipo' => 'success',
                'class' => 'text-success',
                'conteudo' => 'Categoria editada com sucesso!'
            ]);
    }

    public function editarSubCategoria(Request $request, int $subcategoria_id)
    {
        $subcategoria = Subcategoria::find($subcategoria_id);
        $subcategoria->nome = $request->nome;
        $subcategoria->save();

        return redirect()->back()
            ->with('mensagem', [
                'tipo' => 'success',
                'class' => 'text-success',
                'conteudo' => 'Subcategoria editada com sucesso!'
            ]);
    }

    public function excluirCategoria(?int $categoria_id)
    {
        $categoria = Categoria::find($categoria_id);
        $categoria->subcategorias()->delete();
        $categoria->delete();

        return redirect()->back()
            ->with('mensagem', [
                'tipo' => 'success',
                'class' => 'text-success',
                'conteudo' => 'Categoria excluída com sucesso!'
            ]);
    }

    public function excluirSubcategoria(?int $categoria_id, ?int $subcat_id)
    {
        Subcategoria::find($subcat_id)->delete();

        return redirect()->back()
            ->with('mensagem', [
                'tipo' => 'success',
                'class' => 'text-success',
                'conteudo' => 'Subcategoria excluída com sucesso!'
            ]);
    }

    public function getSubcategorias(?int $categoria_id)
    {
        $subcategorias = Subcategoria::where('categoria_id', $categoria_id)->get();

        return response()->json($subcategorias);
    }

    public function getCategorias()
    {
        $categorias = Categoria::with(['subcategorias'])->get();

        return response()->json($categorias);
    }
}
