<?php

namespace App\Http\Controllers\Dashboard\Lancamentos;

use App\Enums\Financeiro\ClienteCategoriaEnum;
use App\Http\Controllers\Controller;
use App\Models\Imports\Analises;
use App\Models\Imports\Servicos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ServicosController extends Controller
{
    public function servicos()
    {
        $servicos = Servicos::with('analises', 'fatura', 'analises.categoriaAnalise', 'cliente', 'cliente.clienteCategoria')
            ->orderBy('collect_date', 'desc')
            ->paginate(10);

        $categorias_analise = ClienteCategoriaEnum::toArray();
        $categorias_cliente = ClienteCategoriaEnum::toArray();

        return Inertia::render('Dashboard/Gerais/Servicos/Listagem', compact('servicos', 'categorias_analise', 'categorias_cliente'));
    }

    public function ajax(Request $request)
    {
        $servicos = Servicos::with('fatura')
            ->where('pet', 'like', '%' . $request->input('termo') . '%')
            ->where('customer', $request->input('cliente_id'))
            ->orderBy('collect_date', 'desc')
            ->where('fatura_id', null)
            ->get();

        return response()->json($servicos);
    }
}
