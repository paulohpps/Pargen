<?php

namespace App\Http\Controllers\Dashboard\DRE;

use App\Http\Controllers\Controller;
use App\Models\Lancamentos\Lancamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DREMensalController extends Controller
{
    public function home(Request $request)
    {
        $ano = $request->ano ?? date('Y');
        $mes = $request->mes ?? date('m');

        $resultado = Lancamento::query()
            ->where('status', 'pago')
            ->whereYear('vencimento', $ano)
            ->whereMonth('vencimento', $mes)
            ->join('pagamentos', 'lancamentos.pagamento_id', '=', 'pagamentos.id')
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
        
        return Inertia::render('Dashboard/DRE/Mensal/Home', compact('categorias', 'ano', 'mes'));
    }
}
