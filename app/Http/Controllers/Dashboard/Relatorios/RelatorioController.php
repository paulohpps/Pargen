<?php

namespace App\Http\Controllers\Dashboard\Relatorios;

use App\Enums\Financeiro\CategoriaAnaliseEnum;
use App\Http\Controllers\Controller;
use App\Models\Imports\Clientes;
use App\Models\Imports\Servicos;
use App\Services\RelatorioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class RelatorioController extends Controller
{
    public function __construct(private RelatorioService $relatorioService)
    {
    }
    public function analiseFinanceira(Request $request)
    {
        $startDate = $request->query('inicio', date('Y-m-d', strtotime('first day of january')));
        $endDate = $request->query('ate', date('Y-m-d', strtotime('last day of december')));

        $receitas = $this->relatorioService->getAnaliseReceitas($startDate, $endDate);
        $pagamentos = $this->relatorioService->getAnalisePagamentos($startDate, $endDate);


        $totalReceitas = str_replace(',', '', $receitas['total_geral']);
        $totalPagamentos = str_replace(',', '', $pagamentos['total_geral']);

        $lucro_total = number_format(floatval($totalReceitas) - floatval($totalPagamentos), 2);

        return Inertia::render('Dashboard/Relatorios/AnaliseFinanceira', compact(['receitas', 'pagamentos', 'lucro_total']));
    }

    public function evolucaoFinanceira(Request $request)
    {
        $ano = $request->query('ano', date('Y'));

        $evolucao_receita = $this->relatorioService->getEvolucaoReceita($ano);
        if (!$evolucao_receita) {
            return redirect()->route('dashboard.analises')->with('mensagem', [
                'tipo' => 'error',
                'class' => 'text-danger',
                'conteudo' => 'Nem todas analises tem categoria definida!'
            ]);
        }

        $categorias_analise = CategoriaAnaliseEnum::toArray();

        $evolucao_pagamentos = $this->relatorioService->getEvolucaoPagamentos($ano);

        return Inertia::render('Dashboard/Relatorios/EvolucaoFinanceira', compact('evolucao_receita', 'categorias_analise', 'evolucao_pagamentos', 'ano'));
    }

    public function rankingClientes(Request $request)
    {
        $mes = $request->query('mes', date('m'));
        $ano = $request->query('ano', date('Y'));
        $clientes = Clientes::select(
            'labs_customer.name as nome',
            DB::raw('SUM(labs_analyze.price) as total'),
            DB::raw('COUNT(DISTINCT labs_petrequest.id) as total_services')
        )
            ->join('labs_petrequest', 'labs_customer.id', '=', 'labs_petrequest.customer')
            ->join('labs_petrequest_analyze', 'labs_petrequest.id', '=', 'labs_petrequest_analyze.petrequest_id')
            ->join('labs_analyze', 'labs_petrequest_analyze.analyze_id', '=', 'labs_analyze.id')
            ->whereMonth('labs_petrequest.collected_date', $mes)
            ->whereYear('labs_petrequest.collected_date', $ano)
            ->groupBy('nome')
            ->orderBy('total', 'desc')
            ->get();

        return Inertia::render('Dashboard/Relatorios/RankingClientes', compact('clientes', 'mes', 'ano'));
    }

    public function servicos()
    {
        $faturamentos = Servicos::selectRaw('count(*) as total')
            ->selectRaw('extract(month from updated_at) as month')
            ->selectRaw("TRIM(DATE_FORMAT(updated_at, '%M')) as month_name")
            ->where('updated_at', '>', now()->subMonths(5))
            ->groupBy('month', 'month_name')
            ->orderBy('month', 'asc')
            ->get();

        return response()->json($faturamentos);
    }

    public function servicosFaturamento()
    {
        $lastSixMonthsRevenue = Servicos::selectRaw('extract(month from labs_petrequest.updated_at) as month')
            ->selectRaw("trim(DATE_FORMAT(labs_petrequest.updated_at, '%M')) as month_name")
            ->selectRaw('sum(labs_analyze.price) as total')
            ->join('labs_petrequest_analyze', 'labs_petrequest.id', '=', 'labs_petrequest_analyze.petrequest_id')
            ->join('labs_analyze', 'labs_petrequest_analyze.analyze_id', '=', 'labs_analyze.id')
            ->where('labs_petrequest.updated_at', '>', now()->subMonths(5))
            ->groupBy('month', 'month_name')
            ->orderBy('month', 'asc')
            ->get();

        return response()->json($lastSixMonthsRevenue);
    }
}
