<?php

namespace App\Http\Controllers\Dashboard\Relatorios;

use App\Enums\Financeiro\CategoriaAnaliseEnum;
use App\Http\Controllers\Controller;
use App\Models\CategoriaAnalise;
use App\Models\Faturas\Fatura;
use App\Models\Imports\Servicos;
use App\Models\Lancamentos\Lancamento;
use App\Services\RelatorioService;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class RelatorioController extends Controller
{
    public function __construct(private RelatorioService $relatorioService)
    {
    }
    public function analiseFinanceira()
    {
        $startDate = '2023-01-01';
        $endDate = '2023-07-31';

        $receitas = $this->relatorioService->getAnaliseReceitas($startDate, $endDate);

        $pagamentos = $this->relatorioService->getAnalisePagamentos($startDate, $endDate);

        return Inertia::render('Dashboard/Relatorios/AnaliseFinanceira', compact(['receitas', 'pagamentos']));
    }

    public function evolucaoFinanceira()
    {
        $year = date('Y');

        $evolucao_receita = $this->relatorioService->getEvolucaoReceita($year);

        $categorias_analise = CategoriaAnaliseEnum::toArray();

        $evolucao_pagamentos = $this->relatorioService->getEvolucaoPagamentos($year);

        return Inertia::render('Dashboard/Relatorios/EvolucaoFinanceira', compact('evolucao_receita', 'categorias_analise', 'evolucao_pagamentos'));
    }

    public function rankingClientes()
    {
        return Inertia::render('Dashboard/Relatorios/RankingClientes');
    }

    public function servicos()
    {
        $faturamentos = Servicos::selectRaw('count(*) as total')
            ->selectRaw('extract(month from created_at) as month')
            ->selectRaw("trim(to_char(created_at, 'month')) as month_name")
            ->where('created_at', '>', now()->subMonths(6))
            ->groupBy('month', 'month_name')
            ->orderBy('month', 'asc')
            ->get();

        return response()->json($faturamentos);
    }

    public function servicosFaturamento()
    {
        $lastSixMonthsRevenue = Servicos::selectRaw('extract(month from labs_petrequest.created_at) as month')
            ->selectRaw("trim(to_char(labs_petrequest.created_at, 'month')) as month_name")
            ->selectRaw('sum(labs_analyze.price) as total')
            ->join('labs_petrequest_analyse', 'labs_petrequest.id', '=', 'labs_petrequest_analyse.petrequest_id')
            ->join('labs_analyze', 'labs_petrequest_analyse.analyze_id', '=', 'labs_analyze.id')
            ->where('labs_petrequest.created_at', '>', now()->subMonths(6))
            ->groupBy('month', 'month_name')
            ->orderBy('month', 'asc')
            ->get();

        return response()->json($lastSixMonthsRevenue);
    }
}
