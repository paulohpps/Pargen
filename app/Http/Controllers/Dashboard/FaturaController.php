<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\Financeiro\ClienteCategoriaEnum;
use App\Enums\Financeiro\FaturaEnum;
use App\Http\Controllers\Controller;
use App\Models\AnaliseServicos;
use App\Models\Faturas\Fatura;
use App\Models\Faturas\FaturaServico;
use App\Models\Imports\Analises;
use App\Models\Imports\Clientes;
use App\Models\Imports\Servicos;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Inertia\Inertia;

class FaturaController extends Controller
{
    public function home()
    {
        $servicos = Servicos::with(['analises', 'cliente', 'cliente.clienteCategoria'])->paginate(10);
        $analises = Analises::with('categoriaAnalise')->get();
        $categorias = ClienteCategoriaEnum::toArray();
        return Inertia::render('Dashboard/Fatura/Geracoes/Listagem', compact('servicos', 'analises', 'categorias'));
    }

    public function faturas(Request $request)
    {
        $faturas = Fatura::with(['fatura_servico', 'fatura_servico.servico'])->paginate(10);

        if($request->status || $request->cliente_id)
        {
            $faturas = Fatura::with(['fatura_servico', 'fatura_servico.servico'])
                ->where('status', $request->status)
                ->orWhere('cliente_id', $request->cliente_id)
                ->paginate(10);
        }

        $status = FaturaEnum::toArray();
        return Inertia::render('Dashboard/Fatura/Faturas/Listagem', compact('faturas', 'status'));
    }

    public function fatura(int $id)
    {
        $fatura = Fatura::find($id);
        $fatura->append('servicos');
        $pdf = Pdf::loadView('fatura', compact('fatura'));
        $pdf = $pdf->setPaper('a4', 'landscape');
        return $pdf->download("fatura.pdf");
    }

    public function faturar()
    {
        $clientes = Clientes::all();
        return Inertia::render('Dashboard/Fatura/Geracoes/Faturar', compact('clientes'));
    }

    public function gerarFatura(Request $request)
    {
        $fatura = Fatura::create([
            'data_vencimento' => Carbon::now()->addDays(10),
            'data_emissao' => Carbon::now(),
            'valor' => 0,
            'status' => FaturaEnum::Aberta,
            'cliente_id' => $request->cliente_id,
        ]);
        $valor = 0;
        for ($i = 0; $i < count($request->servicos); $i++) {
            FaturaServico::create([
                'fatura_id' => $fatura->id,
                'servico_id' => $request->servicos[$i]['id'],
            ]);
            $servicos = Servicos::with('analises')->find($request->servicos[$i]['id']);
            $valor += $servicos->analises->sum('price');
        }

        $fatura->valor = $valor;
        $fatura->save();

        $this->faturas();
        return redirect()->route('dashboard.fatura.faturas');
    }

    public function faturaServico(int $id)
    {
        $fatura = Fatura::find($id);
        $fatura->append('servicos');
        $analises_servicos = AnaliseServicos::with('analise')
            ->where('petrequest_id', $fatura->fatura_servico[0]->servico->id)
            ->get();
        $analises = Analises::with('categoriaAnalise')->get();

        return Inertia::render('Dashboard/Fatura/Faturas/Servicos', compact('fatura', 'analises_servicos', 'analises'));
    }

    public function baixarFatura(int $id)
    {
        $fatura = Fatura::find($id);
        $fatura->append('servicos');
        $analises_servicos = AnaliseServicos::with('analise')
            ->where('petrequest_id', $fatura->fatura_servico[0]->servico->id)
            ->get();

        return Inertia::render('Dashboard/Fatura/Faturas/Baixa', compact('fatura', 'analises_servicos'));
    }

    public function baixar(Request $request)
    {
        $fatura = Fatura::find($request->fatura_id);
        $valorRestante = ($fatura->valor - $fatura->valor_pago) - $request->valorBaixar;
        if ($valorRestante <= 0) {
            $fatura->status = FaturaEnum::Paga;
            $fatura->data_baixa = Carbon::now();
            $fatura->valor_pago += $request->valorBaixar;
        } else if ($valorRestante > 0) {
            $fatura->status = FaturaEnum::Pago_Parcial;
            $fatura->data_baixa = Carbon::now();
            $fatura->valor_pago += $request->valorBaixar;
        }

        $fatura->save();
        return redirect()->route('dashboard.fatura.faturas.baixar');
    }

    public function faturasBaixa()
    {
        $faturas = Fatura::with(['fatura_servico', 'fatura_servico.servico'])->paginate(10);
        $status = FaturaEnum::toArray();
        return Inertia::render('Dashboard/Fatura/Faturas/BaixaFatura', compact('faturas', 'status'));
    }

    public function filtrarFaturas(Request $request)
    {
        $status = FaturaEnum::toArray();
        return Inertia::render('Dashboard/Fatura/Faturas/Listagem', compact('faturas', 'status'));
    }
}
