<?php

namespace App\Http\Controllers\Dashboard\DRE;

use App\Http\Controllers\Controller;
use App\Models\Lancamentos\Lancamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DREAnualController extends Controller
{
    public function home(Request $request)
    {
        $ano = $request->ano ?? date('Y');
        $resultado = Lancamento::query()
            ->where('status', 'pago')
            ->whereYear('vencimento', $ano)
            ->join('pagamentos', 'lancamentos.pagamento_id', '=', 'pagamentos.id')
            ->join('subcategorias', 'pagamentos.subcategoria_id', '=', 'subcategorias.id')
            ->join('categorias', 'subcategorias.categoria_id', '=', 'categorias.id')
            ->select(
                'categorias.nome as categoria',
                'subcategorias.nome as subcategoria',
                DB::raw('MONTH(lancamentos.vencimento) as mes'),
                DB::raw('SUM(lancamentos.valor) as valor_total') // Removed FORMAT
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

            $categorias[$categoria]['subcategorias'][$subcategoria]['valores_por_mes'][$mes] = $valor_total;

            $categorias[$categoria]['valores_por_mes'][$mes] = number_format($categorias[$categoria]['valores_por_mes'][$mes] + $valor_total, 2, '.', '');
        }

        return Inertia::render('Dashboard/DRE/Anual/Home', compact('categorias', 'ano'));
    }
}
