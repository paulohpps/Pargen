<?php

namespace App\Http\Controllers\Dashboard\Lancamentos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Lancamentos\LancamentoRequest;
use App\Models\Lancamentos\Lancamento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LancamentoController extends Controller
{
    public function home()
    {
        $lancamentos = Lancamento::with(['fornecedor', 'funcionario', 'pagamento'])->orderBy('vencimento')->paginate(10);

        foreach ($lancamentos as $lancamento) {
            if ($lancamento->vencimento->isPast() && $lancamento->status != "Pago" && $lancamento->status != "Cancelado") {
                $lancamento->status = "Atrasado";
                $lancamento->save();
            }
        }

        return Inertia::render('Dashboard/Lancamentos/Listagem', compact('lancamentos'));
    }

    public function criar(LancamentoRequest $request)
    {
        if ($request->repetir_parcelas) {
            for ($i = 1; $i <= $request->numero_parcelas; $i++) {
                $lancamento = Lancamento::create($request->all());
                $lancamento->vencimento = $lancamento->vencimento->addMonth($i);
                if ($i > 1 && $request->status == "Pago") {
                    $lancamento->status = "Aberto";
                }
                $lancamento->save();
            }
        } else {
            $lancamento = Lancamento::create($request->all());
        }
        return redirect()->back();
    }

    public function editar(int $id)
    {
        $lancamento = Lancamento::find($id);
        return Inertia::render('Dashboard/Lancamentos/Editar', [
            'lancamento' => $lancamento
        ]);
    }

    public function salvar(Request $request, int $id)
    {
        $lancamento = Lancamento::find($id);
        $lancamento->update($request->all());

        return redirect()->route('dashboard.lancamentos');
    }

    public function excluir(int $id)
    {
        $lancamento = Lancamento::find($id);
        $lancamento->delete();

        return redirect()->back();
    }
}
