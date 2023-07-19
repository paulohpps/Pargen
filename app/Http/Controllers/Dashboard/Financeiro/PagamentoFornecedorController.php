<?php

namespace App\Http\Controllers\Dashboard\Financeiro;

use App\Enums\Financeiro\CategoriaPagamento;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Fornecedores\PagamentoFornecedorRequest;
use App\Models\Financeiro\PagamentoFornecedor;
use App\Models\Gerais\Fornecedor;
use Inertia\Inertia;

class PagamentoFornecedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function pagamentos()
    {
        $pagamentos = PagamentoFornecedor::with(['fornecedor'])->get();
        $categorias = CategoriaPagamento::toArray();
        $fornecedores = Fornecedor::all();

        return Inertia::render('Dashboard/Financeiro/Pagamentos/Fornecedor/Listagem', compact('pagamentos', 'categorias', 'fornecedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function criar(PagamentoFornecedorRequest $request)
    {
        PagamentoFornecedor::create([
            ...$request->all(),
        ]);

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function editar($id)
    {
        $pagamento = PagamentoFornecedor::findOrFail($id);

        return Inertia::render('Financeiro/PagamentosFornecedores/Editar', compact('pagamento'));
    }

    public function salvar(PagamentoFornecedorRequest $pagamentoFornecedor)
    {
        $pagamento = PagamentoFornecedor::findOrFail($pagamentoFornecedor->id);
        $pagamento->update([
            ...$pagamentoFornecedor->all(),
        ]);

        return redirect()->route('pagamentos.fornecedores.listagem');
    }


    public function delete(int $id)
    {
        $pagamento = PagamentoFornecedor::findOrFail($id);
        $pagamento->delete();

        return redirect()->route('pagamentos.fornecedores.listagem');
    }
}
