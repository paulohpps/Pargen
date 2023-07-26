<?php

namespace App\Http\Controllers;

use App\Enums\Financeiro\CategoriaAnaliseEnum;
use App\Models\CategoriaAnalise;
use App\Models\Imports\Analises;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AnalisesController extends Controller
{
    public function listagem()
    {
        $analises = Analises::with('categoriaAnalise')->orderBy('name')->paginate(10);
        $categorias = CategoriaAnaliseEnum::toArray();
        return Inertia::render('Dashboard/Gerais/Analises/Listagem', compact('analises', 'categorias'));
    }

    public function editar(Request $request)
    {
        $categoria = $request->input('categoria');
        $analise_id = $request->input('analise_id');

        $categoriaAnalise = CategoriaAnalise::where('id_analise', $analise_id)->first();

        if ($categoriaAnalise) {
            $categoriaAnalise->categoria = $categoria;
            $categoriaAnalise->save();
        } else {
            $categoriaAnalise = new CategoriaAnalise();
            $categoriaAnalise->id_analise = $analise_id;
            $categoriaAnalise->categoria = $categoria;
            $categoriaAnalise->save();
        }
        return redirect()->back();
    }
}
