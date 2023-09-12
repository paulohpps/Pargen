<?php

namespace App\Services;

use App\Enums\Financeiro\CategoriaAnaliseEnum;
use App\Models\Faturas\Fatura;
use App\Models\Lancamentos\Lancamento;
use Illuminate\Support\Facades\DB;

class RelatorioService
{
    public function getAnaliseReceitas($start, $end)
    {
        $receitas = [];

        $faturas = Fatura::whereBetween('data_emissao', [$start, $end])
            ->get();

        foreach ($faturas->flatMap->servicos->flatMap->analises as $analise) {
            if ($analise->categoriaAnalise) {
                $categoryName = $analise->categoriaAnalise->categoria;
                if (!isset($receitas['categorias'][$categoryName]['total'])) {
                    $receitas['categorias'][$categoryName]['total'] = 0;
                }
                $receitas['categorias'][$categoryName]['total'] += $analise->price;
                $receitas['categorias'][$categoryName]['nome'] = CategoriaAnaliseEnum::names()[$categoryName];
            }
        }
        $totalRevenueAllCategories = 0;
        if (isset($receitas['categorias'])) {

            $totalRevenueAllCategories = array_sum(array_column($receitas['categorias'], 'total'));
            foreach ($receitas['categorias'] as &$categoryData) {
                $categoryData['impacto'] = round(($categoryData['total'] / $totalRevenueAllCategories) * 100, 2);
                $categoryData['impacto'] = round($categoryData['impacto'], 2);
            }
        }
        $receitas['total_geral'] = number_format($totalRevenueAllCategories, 2);

        return $receitas;
    }

    public function getAnalisePagamentos($start, $end)
    {
        $pagamentos = Lancamento::with(['pagamento.subcategoria.categoria'])
            ->selectRaw(
                'categorias.nome as categoria, subcategorias.nome as subcategoria,
                SUM(lancamentos.valor) as total_pago,
                SUM(lancamentos.valor) /
                (SELECT SUM(valor) FROM lancamentos
                WHERE status = "Pago" AND vencimento BETWEEN ? AND ?) * 100 as impacto',
                [$start, $end]
            )
            ->join('pagamentos', 'lancamentos.pagamento_lancamento_id', '=', 'pagamentos.id')
            ->join('subcategorias', 'pagamentos.subcategoria_id', '=', 'subcategorias.id')
            ->join('categorias', 'subcategorias.categoria_id', '=', 'categorias.id')
            ->where('lancamentos.status', 'Pago')
            ->whereBetween('lancamentos.vencimento', [$start, $end])
            ->groupBy('categorias.nome', 'subcategorias.nome')
            ->orderBy('categorias.nome')
            ->orderBy('subcategorias.nome')
            ->get();

        $resultado = $pagamentos->groupBy('categoria')->map(function ($items, $categoria) {
            $total_categoria = $items->sum('total_pago');
            $impacto = $items->sum('impacto');

            return [
                'total_categoria' => number_format($total_categoria, 2, '.', ''),
                'nome' => $categoria,
                'subcategorias' => $items->map(function ($item) {
                    return [
                        'nome' =>  $item['subcategoria'],
                        'valor' =>  $item['total_pago'],
                        'impacto' => round($item['impacto'], 2)
                    ];
                }),
                'impacto' => round($impacto, 2),
            ];
        });

        $pagamentos = [
            'categorias' => $resultado,
            'total_geral' => number_format($resultado->sum('total_categoria'), 2)
        ];
        return $pagamentos;
    }

    public function getEvolucaoReceita($year)
    {
        $query = Fatura::query()
            ->whereYear('data_emissao', $year)
            ->get();

        $evolucao_receita = [];
        foreach ($query as $fatura) {
            foreach ($fatura->servicos as $servico) {
                foreach ($servico->analises as $analise) {
                    if (!$analise->categoriaAnalise) {
                        return null;
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
        return $evolucao_receita;
    }

    public function getEvolucaoPagamentos($year)
    {
        $pagamentos = Lancamento::select(
            'categorias.nome as categoria',
            'subcategorias.nome as subcategoria',
            DB::raw('MONTH(lancamentos.vencimento) as mes'),
            DB::raw('SUM(lancamentos.valor) as total_pago')
        )
            ->join('pagamentos', 'lancamentos.pagamento_lancamento_id', '=', 'pagamentos.id')
            ->join('subcategorias', 'pagamentos.subcategoria_id', '=', 'subcategorias.id')
            ->join('categorias', 'subcategorias.categoria_id', '=', 'categorias.id')
            ->where('lancamentos.status', 'Pago')
            ->whereYear('lancamentos.vencimento', $year)
            ->groupBy('categorias.nome', 'subcategorias.nome', DB::raw('MONTH(lancamentos.vencimento)'))
            ->orderBy('categorias.nome')
            ->orderBy('subcategorias.nome')
            ->orderBy(DB::raw('MONTH(lancamentos.vencimento)'))
            ->get();

        $evolucao_pagamentos = $pagamentos->groupBy('subcategoria')->map(function ($item) {
            return [
                'nome' => $item[0]->subcategoria,
                'meses' => $item->mapWithKeys(function ($pagamento) {
                    return [
                        $pagamento->mes => $pagamento->total_pago
                    ];
                })->toArray()
            ];
        })->values();
        return $evolucao_pagamentos;
    }
}
