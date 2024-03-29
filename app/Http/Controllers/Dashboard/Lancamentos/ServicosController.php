<?php

namespace App\Http\Controllers\Dashboard\Lancamentos;

use App\Enums\Financeiro\CategoriaAnaliseEnum;
use App\Enums\Financeiro\ClienteCategoriaEnum;
use App\Enums\Financeiro\FaturaEnum;
use App\Http\Controllers\Controller;
use App\Models\Imports\Analises;
use App\Models\Imports\Servicos;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\FiltragemServicos;

class ServicosController extends Controller
{
    public function servicos()
    {
        $servicos = Servicos::with('analises', 'fatura', 'analises.categoriaAnalise', 'cliente', 'cliente.clienteCategoria')
            ->orderBy('collect_date', 'desc');

        $servicos = FiltragemServicos::filtrarServicos($servicos, request())->paginate(10);

        $filtros = request()->all();

        $analises = Analises::all();
        $categorias_analise = CategoriaAnaliseEnum::toArray();
        $categorias_cliente = ClienteCategoriaEnum::toArray();
        $fatura_status = FaturaEnum::toArray();

        $servicos->appends(request()->all());

        return Inertia::render('Dashboard/Gerais/Servicos/Listagem', compact('servicos', 'analises', 'filtros', 'categorias_analise', 'categorias_cliente', 'fatura_status'));
    }

    public function ajax(Request $request)
    {
        $servicos = Servicos::with(['fatura', 'analises', 'cliente', 'cliente.clienteCategoria'])
            ->where('pet', 'like', '%' . $request->input('termo') . '%')
            ->where('customer', $request->input('cliente_id'))
            ->where('created_at', '>=', $request->input('data_inicial'))
            ->where('created_at', '<=', $request->input('data_final'))
            ->orderBy('collect_date', 'desc')
            ->where('fatura_id', null)
            ->get();

        return response()->json($servicos);
    }
}
