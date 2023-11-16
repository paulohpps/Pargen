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
        $receitas = Fatura::query()
            ->join('labs_petrequest', 'faturas.id', '=', 'labs_petrequest.fatura_id')
            ->join('labs_petrequest_analyze', 'labs_petrequest.id', '=', 'labs_petrequest_analyze.petrequest_id')
            ->join('labs_analyze', 'labs_petrequest_analyze.analyze_id', '=', 'labs_analyze.id')
            ->join('categoria_analises', 'labs_analyze.id', '=', 'categoria_analises.id_analise')
            ->whereBetween('faturas.data_emissao', [$start, $end])
            ->select(
                'categoria_analises.categoria',
                DB::raw('SUM(labs_analyze.price) as total'),
                DB::raw('categoria_analises.categoria as nome')
            )
            ->groupBy('categoria_analises.categoria')
            ->get()
            ->toArray();

        $totalRevenueAllCategories = array_sum(array_column($receitas, 'total'));

        $receitas['categorias'] = array_map(function ($item) use ($totalRevenueAllCategories) {
            $item['impacto'] = round(($item['total'] / $totalRevenueAllCategories) * 100, 2);
            $item['nome'] = CategoriaAnaliseEnum::names()[$item['categoria']];
            return $item;
        }, $receitas);

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

    public function getRecebimentoTotal($startDate, $endDate)
    {
        $recebimento_total = Fatura::whereBetween('data_emissao', [$startDate, $endDate])
            ->sum('valor_pago');

        return number_format($recebimento_total, 2);
    }

    public function getEvolucaoReceita($year)
    {
        $evolucao_receita = Fatura::selectRaw('categoria_analises.categoria, MONTH(faturas.data_emissao) as month, SUM(labs_analyze.price) as total')
            ->join('labs_petrequest', 'faturas.id', '=', 'labs_petrequest.fatura_id')
            ->join('labs_petrequest_analyze', 'labs_petrequest.id', '=', 'labs_petrequest_analyze.petrequest_id')
            ->join('labs_analyze', 'labs_petrequest_analyze.analyze_id', '=', 'labs_analyze.id')
            ->join('categoria_analises', 'labs_analyze.id', '=', 'categoria_analises.id_analise')
            ->whereYear('faturas.data_emissao', $year)
            ->groupBy('categoria_analises.categoria', 'month')
            ->orderBy('categoria_analises.categoria', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            ->groupBy('categoria');

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
