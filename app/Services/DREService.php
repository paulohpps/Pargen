<?php

namespace App\Services;

use App\Enums\Financeiro\CategoriaAnaliseEnum;
use App\Enums\Financeiro\FaturaEnum;
use App\Models\Faturas\Fatura;
use App\Models\Imports\Analises;
use App\Models\Lancamentos\Lancamento;
use Illuminate\Support\Facades\DB;

class DREService
{
    public static function GetCategoriasDreMensal($ano, $mes)
    {
        $resultado = Lancamento::query()
            ->where('status', 'pago')
            ->whereYear('vencimento', $ano)
            ->whereMonth('vencimento', $mes)
            ->join('pagamentos', 'lancamentos.pagamento_lancamento_id', '=', 'pagamentos.id')
            ->join('subcategorias', 'pagamentos.subcategoria_id', '=', 'subcategorias.id')
            ->join('categorias', 'subcategorias.categoria_id', '=', 'categorias.id')
            ->select(
                'categorias.nome as categoria',
                'subcategorias.nome as subcategoria',
                DB::raw('MONTH(lancamentos.vencimento) as mes'),
                DB::raw('DAY(lancamentos.vencimento) as dia'),
                DB::raw('SUM(lancamentos.valor) as valor_total')
            )
            ->groupBy('categorias.nome', 'subcategorias.nome', DB::raw('MONTH(lancamentos.vencimento)'), DB::raw('DAY(lancamentos.vencimento)'))
            ->orderBy('categorias.nome')
            ->orderBy('subcategorias.nome')
            ->orderBy(DB::raw('MONTH(lancamentos.vencimento)'))
            ->orderBy(DB::raw('DAY(lancamentos.vencimento)'))
            ->get();

        $daysInMonth = now()->daysInMonth;

        $categorias = [];

        foreach ($resultado as $item) {
            $categoria = $item->categoria;
            $subcategoria = $item->subcategoria;
            $mes = $item->mes;
            $dia = $item->dia;
            $valor_total = $item->valor_total;

            if (!isset($categorias[$categoria])) {
                $categorias[$categoria] = [
                    'nome' => $categoria,
                    'valores_por_dia' => array_fill(1, $daysInMonth, 0),
                    'subcategorias' => [],
                ];
            }

            if (!isset($categorias[$categoria]['subcategorias'][$subcategoria])) {
                $categorias[$categoria]['subcategorias'][$subcategoria] = [
                    'nome' => $subcategoria,
                    'valores_por_dia' => array_fill(1, $daysInMonth, 0),
                ];
            }

            $categorias[$categoria]['subcategorias'][$subcategoria]['valores_por_dia'][$dia] = $valor_total + 0;

            $categorias[$categoria]['valores_por_dia'][$dia] += $valor_total + 0;
        }

        return $categorias;
    }

    public static function GetCategoriasDreAnual($ano)
    {
        $resultado = Lancamento::query()
            ->where('status', 'pago')
            ->whereYear('vencimento', $ano)
            ->join('pagamentos', 'lancamentos.pagamento_lancamento_id', '=', 'pagamentos.id')
            ->join('subcategorias', 'pagamentos.subcategoria_id', '=', 'subcategorias.id')
            ->join('categorias', 'subcategorias.categoria_id', '=', 'categorias.id')
            ->select(
                'categorias.nome as categoria',
                'subcategorias.nome as subcategoria',
                DB::raw('MONTH(lancamentos.vencimento) as mes'),
                DB::raw('SUM(lancamentos.valor) as valor_total')
            )
            ->groupBy('categorias.nome', 'subcategorias.nome', DB::raw('MONTH(lancamentos.vencimento)'))
            ->orderBy('categorias.nome')
            ->orderBy('subcategorias.nome')
            ->orderBy(DB::raw('MONTH(lancamentos.vencimento)'))
            ->get();

        $categorias = [];

        foreach ($resultado as $item) {
            $categoria = $item->categoria;
            $subcategoria = $item->subcategoria;
            $mes = $item->mes;
            $valor_total = $item->valor_total;

            if (!isset($categorias[$categoria])) {
                $categorias[$categoria] = [
                    'nome' => $categoria,
                    'valores_por_mes' => [],
                    'subcategorias' => [],
                ];

                for ($i = 1; $i <= 12; $i++) {
                    $categorias[$categoria]['valores_por_mes'][$i] = 0.00;
                }
            }

            if (!isset($categorias[$categoria]['subcategorias'][$subcategoria])) {
                $categorias[$categoria]['subcategorias'][$subcategoria] = [
                    'nome' => $subcategoria,
                    'valores_por_mes' => [],
                ];

                for ($i = 1; $i <= 12; $i++) {
                    $categorias[$categoria]['subcategorias'][$subcategoria]['valores_por_mes'][$i] = 0.00;
                }
            }

            $categorias[$categoria]['subcategorias'][$subcategoria]['valores_por_mes'][$mes] = $valor_total + 0;

            $categorias[$categoria]['valores_por_mes'][$mes] = number_format($categorias[$categoria]['valores_por_mes'][$mes] + $valor_total, 2, '.', '') + 0;
        }

        return $categorias;
    }

    public static function GetReceitasDreMensal($ano, $mes)
    {
        $resultado = DB::table('labs_analyze')
            ->join('labs_petrequest_analyze', 'labs_analyze.id', '=', 'labs_petrequest_analyze.analyze_id')
            ->join('labs_petrequest', 'labs_petrequest_analyze.petrequest_id', '=', 'labs_petrequest.id')
            ->join('faturas', 'labs_petrequest.fatura_id', '=', 'faturas.id')
            ->join('categoria_analises', 'categoria_analises.id_analise', '=', 'labs_analyze.id')
            ->select(
                DB::raw('ROUND(SUM(labs_analyze.price * (faturas.valor_pago / faturas.valor)), 2) as valor_total'),
                DB::raw('day(faturas.data_baixa) as dia'),
                'categoria_analises.categoria'
            )

            ->whereYear('faturas.data_baixa', '=', $ano)
            ->whereMonth('faturas.data_baixa', '=', $mes)
            ->groupBy('categoria_analises.categoria', DB::raw('day(faturas.data_baixa)'))
            ->get();

        $categorias = [];
        $daysInMonth = now()->daysInMonth;

        foreach ($resultado as $item) {
            $categoria = $item->categoria;
            $dia = $item->dia;
            $valor_total = $item->valor_total;

            if (!isset($categorias[$categoria])) {
                $categorias[$categoria] = [
                    'nome' => CategoriaAnaliseEnum::names()[$categoria],
                    'dias' => array_fill(1, $daysInMonth, [
                        'dia' => 0,
                        'valor_total' => 0
                    ])
                ];
            }

            $categorias[$categoria]['dias'][$dia] = [
                'dia' => $dia,
                'valor_total' => $valor_total + 0
            ];
        }

        $categorias = array_values($categorias);

        return $categorias;
    }

    public static function GetReceitasDreAnual($ano)
    {
        $resultado = DB::table('labs_analyze')
            ->join('labs_petrequest_analyze', 'labs_analyze.id', '=', 'labs_petrequest_analyze.analyze_id')
            ->join('labs_petrequest', 'labs_petrequest_analyze.petrequest_id', '=', 'labs_petrequest.id')
            ->join('faturas', 'labs_petrequest.fatura_id', '=', 'faturas.id')
            ->join('categoria_analises', 'categoria_analises.id_analise', '=', 'labs_analyze.id')
            ->select(
                DB::raw('ROUND(SUM(labs_analyze.price * (faturas.valor_pago / faturas.valor)), 2) as valor_total'),
                DB::raw('MONTH(faturas.data_baixa) as mes'),
                'categoria_analises.categoria'
            )
            ->whereYear('faturas.data_baixa', $ano)
            ->groupBy('categoria_analises.categoria', DB::raw('MONTH(faturas.data_baixa)'))
            ->get();

        $categorias = [];

        foreach ($resultado as $item) {
            $categoria = $item->categoria;
            $mes = $item->mes;
            $valor_total = $item->valor_total;

            if (!isset($categorias[$categoria])) {
                $categorias[$categoria] = [
                    'nome' => CategoriaAnaliseEnum::names()[$categoria],
                    'meses' => array_fill(1, 12, [
                        'mes' => 0,
                        'valor_total' => 0
                    ])
                ];
            }

            $categorias[$categoria]['meses'][$mes] = [
                'mes' => $mes,
                'valor_total' => $valor_total
            ];
        }

        $categorias = array_values($categorias);

        return $categorias;
    }
}
