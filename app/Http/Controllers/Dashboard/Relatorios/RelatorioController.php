<?php

namespace App\Http\Controllers\Dashboard\Relatorios;

use App\Enums\Financeiro\CategoriaAnaliseEnum;
use App\Http\Controllers\Controller;
use App\Models\CategoriaAnalise;
use App\Models\Faturas\Fatura;
use App\Models\Imports\Servicos;
use App\Models\Lancamentos\Lancamento;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class RelatorioController extends Controller
{
    public function analiseFinanceira()
    {
        $startDate = '2023-01-01';
        $endDate = '2023-07-31';

        $receitas = [];

        $faturas = Fatura::whereBetween('data_emissao', [$startDate, $endDate])
            ->get();

        foreach ($faturas as $fatura) {
            foreach ($fatura->servicos as $servico) {
                foreach ($servico->analises as $analise) {
                    if (!$analise->categoriaAnalise) {
                        continue; // Skip if the analysis doesn't have a defined category
                    }

                    $categoryName = $analise->categoriaAnalise->categoria;
                    $revenue = $analise->price;

                    if (!isset($receitas[$categoryName]['total'])) {
                        $receitas[$categoryName]['total'] = 0;
                    }

                    $receitas[$categoryName]['total'] += $revenue;
                    $receitas[$categoryName]['nome'] = CategoriaAnaliseEnum::names()[$categoryName];
                }
            }
        }

        $totalRevenueAllCategories = array_sum(array_column($receitas, 'total'));


        foreach ($receitas as &$categoryData) {
            $categoryData['impacto'] = ($categoryData['total'] / $totalRevenueAllCategories) * 100;
            $categoryData['impacto'] = round($categoryData['impacto'], 2);
        }
        $receitas['total_geral'] = $totalRevenueAllCategories;

        $pagamentos = Lancamento::with(['pagamento.subcategoria.categoria'])
            ->select(
                'categorias.nome as categoria',
                'subcategorias.nome as subcategoria',
                DB::raw('SUM(lancamentos.valor) as total_pago'),
                DB::raw('SUM(lancamentos.valor) / (SELECT SUM(valor) FROM lancamentos WHERE status = "Pago" AND vencimento BETWEEN "' . $startDate . '" AND "' . $endDate . '") * 100 as impacto')
            )
            ->join('pagamentos', 'lancamentos.pagamento_lancamento_id', '=', 'pagamentos.id')
            ->join('subcategorias', 'pagamentos.subcategoria_id', '=', 'subcategorias.id')
            ->join('categorias', 'subcategorias.categoria_id', '=', 'categorias.id')
            ->where('lancamentos.status', 'Pago')
            ->whereBetween('lancamentos.vencimento', [$startDate, $endDate])
            ->groupBy('categorias.nome', 'subcategorias.nome')
            ->orderBy('categorias.nome')
            ->orderBy('subcategorias.nome')
            ->get();

        $resultado = $pagamentos->groupBy('categoria')->map(function ($items, $categoria) {
            $total_categoria = $items->sum('total_pago');
            $impacto = $items->sum('impacto');

            return [
                'total_categoria' => $total_categoria,
                'nome' => $categoria,
                'subcategorias' => $items->map(function ($item) {
                    return [
                        'nome' =>  $item['subcategoria'],
                        'valor' => round($item['total_pago']),
                        'impacto' => round($item['impacto'], 2)
                    ];
                }),
                'impacto' => round($impacto, 2),
            ];
        });

        $pagamentos = [
            'categorias' => $resultado,
            'total_geral' => $resultado->sum('total_categoria')
        ];

        return Inertia::render('Dashboard/Relatorios/AnaliseFinanceira', compact(['receitas', 'pagamentos', 'categorias_analise']));
    }

    public function evolucaoFinanceira()
    {
        $year = date('Y');
        $month = date('m');

        $query = Fatura::query()
            ->whereYear('data_emissao', $year)
            ->whereMonth('data_emissao', $month)
            ->get();

        $evolucao_receita = [];
        foreach ($query as $fatura) {
            foreach ($fatura->servicos as $servico) {
                foreach ($servico->analises as $analise) {
                    if (!$analise->categoriaAnalise) {
                        return redirect()->back()->with('mensagem', [
                            'tipo' => 'error',
                            'class' => 'text-danger',
                            'conteudo' => 'Nem todas analises tem categoria definida!'
                        ]);
                    }
                    $category = $analise->categoriaAnalise->categoria;
                    $month = $fatura->data_emissao->format('m');

                    if (!isset($evolucao_receita[$category])) {
                        $evolucao_receita[$category] = array_fill(1, 12, 0);
                    }

                    $evolucao_receita[$category][(int)$month] += $analise->price;
                }
            }
        }

        $categorias_analise = CategoriaAnaliseEnum::toArray();

        $evolucao_pagamentos = [];

        foreach ($query as $fatura) {
            foreach ($fatura->servicos as $servico) {
                foreach ($servico->analises as $analise) {
                    if (!$analise->categoriaAnalise) {
                        continue;
                    }

                    $category = $analise->categoriaAnalise->categoria;
                    $month = $fatura->data_emissao->format('m');
                    $revenue = $analise->price;


                    if (!isset($evolucao_pagamentos[$category][$month])) {
                        $evolucao_pagamentos[$category]['nome'] = CategoriaAnaliseEnum::names()[$category];
                        $evolucao_pagamentos[$category]['meses'][$month] = 0;
                    }

                    $evolucao_pagamentos[$category]['meses'][$month] += $revenue;
                }
            }
        }

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
