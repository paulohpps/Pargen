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

        $categorias = DREService::GetCategoriasDreMensal($ano, $mes);
        $receitas = DREService::GetReceitasDreMensal($ano, $mes);

        return Inertia::render('Dashboard/DRE/Mensal/Home', compact('categorias', 'receitas', 'ano', 'mes'));
    }
}
