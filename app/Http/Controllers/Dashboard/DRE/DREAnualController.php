<?php

namespace App\Http\Controllers\Dashboard\DRE;

use App\Http\Controllers\Controller;
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

        return Inertia::render('Dashboard/DRE/Anual/Home', compact('categorias', 'receitas', 'ano'));
    }
}
