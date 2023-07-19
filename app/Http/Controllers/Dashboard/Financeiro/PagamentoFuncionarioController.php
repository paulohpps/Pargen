<?php

namespace App\Http\Controllers\Dashboard\Financeiro;

use App\Enums\Financeiro\CategoriaPagamento;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Funcionarios\PagamentoFuncionarioRequest;
use App\Models\Financeiro\PagamentoFuncionario;
use App\Models\Gerais\Funcionario;
use Inertia\Inertia;

class PagamentoFuncionarioController extends Controller
{
    public function pagamentos()
    {
        $pagamentos = PagamentoFuncionario::with(['funcionario'])->get();
        $categorias = CategoriaPagamento::toArray();
        $funcionarios = Funcionario::all();

        return Inertia::render('Dashboard/Financeiro/Pagamentos/Funcionario/Listagem', compact('pagamentos', 'categorias', 'funcionarios'));
    }

    public function criar(PagamentoFuncionarioRequest $request)
    {
        PagamentoFuncionario::create([
            ...$request->all(),
        ]);

        return redirect()->back();
    }

    public function editar($id)
    {
        $pagamento = PagamentoFuncionario::findOrFail($id);
        $categorias = CategoriaPagamento::toArray();

        return Inertia::render('Financeiro/PagamentosFuncionarios/Editar', compact('pagamento', 'categorias'));
    }

    public function salvar(PagamentoFuncionarioRequest $pagamentoFuncionario)
    {
        $pagamento = PagamentoFuncionario::findOrFail($pagamentoFuncionario->id);
        $pagamento->update([
            ...$pagamentoFuncionario->all(),
        ]);

        return redirect()->route('pagamentos.funcionarios.listagem');
    }

    public function excluir(int $id)
    {
        $pagamento = PagamentoFuncionario::findOrFail($id);
        $pagamento->delete();

        return redirect()->route('pagamentos.funcionarios.listagem');
    }
}
