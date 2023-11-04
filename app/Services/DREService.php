<?php

namespace App\Services;

use App\Enums\Financeiro\CategoriaAnaliseEnum;
use App\Enums\Financeiro\FaturaEnum;
use App\Models\Faturas\Fatura;
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

        $daysInMonth = date('t', mktime(0, 0, 0, $mes, 1, $ano));

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
        /*
        SELECT
            SUM(labs_analyze.price) as total, day(faturas.data_baixa) as dia, categoria_analises.categoria
        FROM
            labs_analyze
            join labs_petrequest_analyze on labs_analyze.id = labs_petrequest_analyze.analyze_id
            join labs_petrequest on labs_petrequest_analyze.petrequest_id = labs_petrequest.id
            join faturas ON labs_petrequest.fatura_id = faturas.id
            join categoria_analises on categoria_analises.id_analise = labs_analyze.id
        WHERE
            faturas.status = 1
                AND YEAR(faturas.data_baixa) = 2023
                AND MONTH(faturas.data_baixa) = 11

        group by categoria_analises.categoria, day(faturas.data_baixa)
        */


        $resultado = Fatura::query()
            ->where('faturas.status', FaturaEnum::Paga)
            ->whereYear('faturas.data_baixa', $ano)
            ->whereMonth('faturas.data_baixa', $mes)
            ->join('labs_petrequest', 'faturas.id', '=', 'labs_petrequest.fatura_id')
            ->join('labs_petrequest_analyze', 'labs_petrequest.id', '=', 'labs_petrequest_analyze.petrequest_id')
            ->join('labs_analyze', 'labs_petrequest_analyze.analyze_id', '=', 'labs_analyze.id')
            ->join('categoria_analises', 'labs_analyze.id', '=', 'categoria_analises.id_analise')
            ->select(
                'categoria_analises.categoria as categoria',
                DB::raw('DAY(labs_petrequest.created_at) as dia'),
                DB::raw('SUM(labs_analyze.price) as valor_total')
            )
            ->groupBy('categoria_analises.categoria', DB::raw('DAY(labs_petrequest.created_at)'))
            ->orderBy('categoria_analises.categoria')
            ->orderBy(DB::raw('DAY(labs_petrequest.created_at)'))
            ->get();

        $categorias = [];

        foreach ($resultado as $item) {
            $categoria = $item->categoria;
            $dia = $item->dia;
            $valor_total = $item->valor_total;

            if (!isset($categorias[$categoria])) {
                $categorias[$categoria] = [
                    'nome' => CategoriaAnaliseEnum::names()[$categoria],
                    'dias' => array_fill(1, 31, [
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
        $resultado = Fatura::query()
            ->where('faturas.status', FaturaEnum::Paga)
            ->whereYear('data_emissao', $ano)
            ->join('labs_petrequest', 'faturas.id', '=', 'labs_petrequest.fatura_id')
            ->join('labs_petrequest_analyze', 'labs_petrequest.id', '=', 'labs_petrequest_analyze.petrequest_id')
            ->join('labs_analyze', 'labs_petrequest_analyze.analyze_id', '=', 'labs_analyze.id')
            ->join('categoria_analises', 'labs_analyze.id', '=', 'categoria_analises.id_analise')
            ->select(
                'categoria_analises.categoria as categoria',
                DB::raw('MONTH(labs_petrequest.created_at) as mes'),
                DB::raw('SUM(labs_analyze.price) as valor_total')
            )
            ->groupBy('categoria_analises.categoria', DB::raw('MONTH(labs_petrequest.created_at)'))
            ->orderBy('categoria_analises.categoria')
            ->orderBy(DB::raw('MONTH(labs_petrequest.created_at)'))
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
