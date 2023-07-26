<?php

namespace App\Http\Controllers;

use App\Enums\Financeiro\ClienteCategoriaEnum;
use App\Models\ClienteCategoria;
use App\Models\Imports\Clientes;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClientesController extends Controller
{
    public function clientes()
    {
        $clientes = Clientes::with(['ClienteCategoria'])->orderBy('name')->paginate(20);
        $categorias = ClienteCategoriaEnum::toArray();

        return Inertia::render('Dashboard/Gerais/Clientes/Listagem', compact('clientes', 'categorias'));
    }

    public function editarCategoria(Request $request)
    {
        $categoria = $request->input('categoria');
        $usuario_id = $request->input('usuario_id');

        $clienteCategoria = ClienteCategoria::where('id_cliente', $usuario_id)->first();

        if ($clienteCategoria) {
            $clienteCategoria->categoria = $categoria;
            $clienteCategoria->save();
        } else {
            $clienteCategoria = new ClienteCategoria();
            $clienteCategoria->id_cliente = $usuario_id;
            $clienteCategoria->categoria = $categoria;
            $clienteCategoria->save();
        }
        return redirect()->back();
    }

    public function clienteJson(Request $request)
    {
        $cliente = Clientes::select('id', 'name as texto')
            ->where('name', 'like', '%' . $request->input('termo') . '%')
            ->get();

        return response()->json($cliente);
    }
}
