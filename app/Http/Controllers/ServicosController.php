<?php

namespace App\Http\Controllers;

use App\Enums\Financeiro\CategoriaAnaliseEnum;
use App\Enums\Financeiro\ClienteCategoriaEnum;
use App\Models\Imports\Analises;
use App\Models\Imports\Servicos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ServicosController extends Controller
{
    public function servicos()
    {
        $servicos = Servicos::with('analises', 'cliente', 'cliente.clienteCategoria')->paginate(10);
        $analises = Analises::with('categoriaAnalise')->get();
        $categorias = ClienteCategoriaEnum::toArray();

        return Inertia::render('Dashboard/Gerais/Servicos/Listagem', compact('servicos', 'analises', 'categorias'));
    }

    public function detalhes($id)
    {
        $servicos = Servicos::where('id', $id)->first();

        return Inertia::render('Dashboard/Gerais/Servicos/Detalhes', compact('servicos'));
    }

    public function criar()
    {
        return Inertia::render('Dashboard/Gerais/Servicos/Criar');
    }

    public function salvar()
    {
        Servicos::create(request()->all());

        return redirect()->route('servicos');
    }

    public function editar($id)
    {
        $servicos = Servicos::where('id', $id)->first();

        return Inertia::render('Dashboard/Gerais/Servicos/Editar', compact('servicos'));
    }

    public function atualizar($id)
    {
        $servicos = Servicos::where('id', $id)->first();

        $servicos->update(request()->all());

        return redirect()->route('servicos.detalhes', $id);
    }

    public function deletar($id)
    {
        $servicos = Servicos::where('id', $id)->first();

        $servicos->delete();

        return redirect()->route('servicos');
    }

    public function ajax(Request $request)
    {
        $servicos = Servicos::select('id', DB::raw("CONCAT(pet,' - ' ,   tutor ) as texto"))
            ->where('pet', 'like', '%' . $request->input('termo') . '%')
            ->where('customer_id', $request->input('cliente_id'))
            ->take(10)->get();

        return response()->json($servicos);
    }
}
