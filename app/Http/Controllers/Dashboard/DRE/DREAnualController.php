<?php

namespace App\Http\Controllers\Dashboard\DRE;

use App\Http\Controllers\Controller;
use App\Models\Financeiro\Categorias\Categoria;
use App\Models\Lancamentos\Lancamento;
use App\Services\DREService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DREAnualController extends Controller
{
    public function home(Request $request)
    {
        $ano = $request->ano ?? date('Y');

        $categorias = DREService::GetCategoriasDreAnual($ano);
        $receitas = DREService::GetReceitasDreAnual($ano);

        $resultadosCategoria = array_fill(1, 12, 0);
        $resultadosReceita = array_fill(1, 12, 0);

        foreach ($categorias as $categoria) {
            foreach ($categoria['valores_por_mes'] as $mes => $valor) {
                $resultadosCategoria[$mes] += $valor;
            }
        }

        foreach ($receitas as $receita) {
          foreach ($receita['meses'] as $mes) {
                if($mes['mes'] == 0)
                    continue;
                $resultadosReceita[$mes['mes']] += $mes['valor_total'];
            }
        }

        $resultados_final = [];

        for ($mes = 1; $mes <= 12; $mes++) {
            $resultado_mes = $resultadosReceita[$mes] - $resultadosCategoria[$mes] ;
            $resultados_final[$mes] = $resultado_mes;
        }

        return Inertia::render('Dashboard/DRE/Anual/Home', compact('categorias', 'receitas', 'resultados_final', 'ano'));
    }
}
