<?php

namespace App\Http\Controllers\Dashboard\DRE;

use App\Http\Controllers\Controller;
use App\Services\DREService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DREMensalController extends Controller
{
    public function home(Request $request)
    {
        $ano = $request->ano ?? date('Y');
        $mes = $request->mes ?? date('m');

        $receitas = DREService::GetReceitasDreMensal($ano, $mes);

        $categorias = DREService::GetCategoriasDreMensal($ano, $mes);

        $resultadosCategoria = array_fill(1, 31, 0);
        $resultadosReceita = array_fill(1, 31, 0);

        foreach ($categorias as $categoria) {
            foreach ($categoria['valores_por_dia'] as $dia => $valor) {
                $resultadosCategoria[$dia] += $valor;
            }
        }

        foreach ($receitas as $receita) {
            foreach ($receita['dias'] as $dia => $valor) {
                $resultadosReceita[$dia] += $valor['valor_total'];
            }
        }

        $resultados_final = [];

        for ($dia = 1; $dia <= 31; $dia++) {
            $resultado_dia = $resultadosReceita[$dia] - $resultadosCategoria[$dia];
            $resultados_final[$dia] = $resultado_dia;

            if ($dia > 1) {
                //$resultados_final[$dia] += $resultados_final[$dia - 1];
            }
        }

        return Inertia::render('Dashboard/DRE/Mensal/Home', compact('categorias', 'receitas', 'ano', 'mes', 'resultados_final'));
    }
}
