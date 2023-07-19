<?php

namespace App\Http\Controllers;

use App\Http\Requests\Dashboard\Lancamentos\LancamentoRequest;
use App\Models\Lancamentos\Lancamento;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LancamentoController extends Controller
{
    public function home()
    {
        $lancamentos = Lancamento::with(['fornecedor', 'funcionario', 'pagamento'])->paginate(10);

        return Inertia::render('Dashboard/Lancamentos/Listagem', compact('lancamentos'));
    }

    public function criar(LancamentoRequest $request)
    {
        if ($request->repetir_parcelas) {
            for ($i = 1; $i <= $request->numero_parcelas; $i++) {
                $lancamento = Lancamento::create($request->all());
                $lancamento->vencimento = $lancamento->vencimento->addMonth($i);
                $lancamento->save();
            }
        } else {
            $lancamento = Lancamento::create($request->all());
        }
        return redirect()->route('dashboard.lancamentos');
    }

    public function editar(int $id)
    {
        $lancamento = Lancamento::find($id);
        return Inertia::render('Dashboard/Lancamentos/Editar', [
            'lancamento' => $lancamento
        ]);
    }

    public function salvar(LancamentoRequest $request, int $id)
    {
        $lancamento = Lancamento::find($id);
        $lancamento->update($request->all());

        return redirect()->route('lancamentos');
    }

    public function deletar(int $id)
    {
        $lancamento = Lancamento::find($id);
        $lancamento->delete();

        return redirect()->route('lancamentos');
    }
}
