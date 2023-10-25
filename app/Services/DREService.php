<?php

namespace App\Services;

use App\Enums\Financeiro\CategoriaAnaliseEnum;
use App\Models\CategoriaAnalise;
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

            $categorias[$categoria]['subcategorias'][$subcategoria]['valores_por_dia'][$dia] = $valor_total;

            $categorias[$categoria]['valores_por_dia'][$dia] += $valor_total;
        }

        return $categorias;
    }

    public static function GetReceitasDreMensal($ano, $mes)
    {
        $resultado = DB::table('categoria_analises as ca')
            ->select(DB::raw('DAY(lpr.created_at) AS dia, ca.categoria AS categoria, SUM(a.price) AS valor_total'))
            ->join('labs_analyze', 'ca.id_analise', '=', 'labs_analyze.id')
            ->join('labs_petrequest_analyze', 'labs_analyze.id', '=', 'labs_petrequest_analyze.analyze_id')
            ->join('labs_petrequest as lpr', 'labs_petrequest_analyze.petrequest_id', '=', 'lpr.id')
            ->join('labs_analyze as a', 'labs_petrequest_analyze.analyze_id', '=', 'a.id')
            ->whereYear('lpr.created_at', $ano)
            ->whereMonth('lpr.created_at', $mes)
            ->groupBy('dia', 'categoria')
            ->orderBy('dia', 'asc')
            ->orderBy('categoria', 'asc')
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

            /*for ($dia = 1; $dia <= 31; $dia++) {
                $categorias[$categoria]['dias'][$dia] = [
                    'dia' => $dia,
                    'valor_total' => 0
                ];
            }*/

            $categorias[$categoria]['dias'][$dia] = [
                'dia' => $dia,
                'valor_total' => $valor_total
            ];
        }

        $categorias = array_values($categorias);

        return $categorias;
    }
}
