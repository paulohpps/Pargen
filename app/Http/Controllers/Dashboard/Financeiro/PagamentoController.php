<?php

namespace App\Http\Controllers\Dashboard\Financeiro;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Financeiro\PagamentoRequest;
use App\Models\Financeiro\Categorias\Categoria;
use App\Models\Financeiro\Pagamento;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PagamentoController extends Controller
{
    public function pagamentos()
    {
        $pagamentos = Pagamento::with(['categoria', 'subcategoria'])->orderBy('descricao')->paginate(10);
        $categorias = Categoria::with('subcategorias')->get();

        return Inertia::render('Dashboard/Financeiro/Pagamentos/Listagem', compact('pagamentos', 'categorias'));
    }

    public function criar(PagamentoRequest $request)
    {
        Pagamento::create([
            ...$request->all(),
        ]);

        return redirect()->back()
            ->with('mensagem', [
                'tipo' => 'success',
                'class' => 'text-success',
                'conteudo' => 'Pagamento criado com sucesso!'
            ]);
    }

    public function editar(int $id)
    {
        $pagamento = Pagamento::with(['categoria', 'categoria.subcategorias', 'subcategoria'])->find($id);

        $categorias = Categoria::with('subcategorias')->get();
        return Inertia::render('Dashboard/Financeiro/Pagamentos/Editar', compact('pagamento', 'categorias'));
    }

    public function salvar(Request $request, int $id)
    {
        $pagamento = Pagamento::find($id);
        $pagamento->update($request->all());
        return redirect('/dashboard/financeiro/pagamentos')
            ->with('mensagem', [
                'tipo' => 'success',
                'class' => 'text-success',
                'conteudo' => 'Pagamento atualizado com sucesso!'
            ]);
    }

    public function excluir(int $id)
    {
        Pagamento::find($id)->delete();
        return redirect('/dashboard/financeiro/pagamentos')
            ->with('mensagem', [
                'tipo' => 'success',
                'class' => 'text-success',
                'conteudo' => 'Pagamento excluído com sucesso!'
            ]);
    }

    public function consultar()
    {
        $pagamentos = Pagamento::all();
        return response()->json($pagamentos);
    }
}
