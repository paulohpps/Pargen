<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\Financeiro\ClienteCategoriaEnum;
use App\Enums\Financeiro\FaturaEnum;
use App\Http\Controllers\Controller;
use App\Models\Faturas\Fatura;
use App\Models\Imports\Analises;
use App\Models\Imports\AnaliseServicos;
use App\Models\Imports\Clientes;
use App\Models\Imports\Servicos;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Inertia\Inertia;

class FaturaController extends Controller
{
    public function home()
    {
        $servicos = Servicos::with(['analises', 'cliente', 'cliente.clienteCategoria'])
            ->where('fatura_id', null)
            ->orderBy('collect_date', 'desc')
            ->paginate(10);

        $analises = Analises::with('categoriaAnalise')->get();
        $categorias = ClienteCategoriaEnum::toArray();

        return Inertia::render('Dashboard/Fatura/Geracoes/Listagem', compact('servicos', 'analises', 'categorias'));
    }

    public function faturas(Request $request)
    {
        $faturas = Fatura::query();

        if ($request->status != null) {
            $faturas->where('status', $request->status);
        }
        if ($request->cliente_id) {
            $faturas->where('cliente_id', $request->cliente_id);
        }

        $faturas = $faturas->with(['servicos'])->paginate(10);

        $status = FaturaEnum::toArray();

        Artisan::call('atualizar:faturas');

        return Inertia::render('Dashboard/Fatura/Faturas/Listagem', compact('faturas', 'status'));
    }

    public function fatura(int $id)
    {
        $fatura = Fatura::with(['cliente', 'servicos'])->find($id);

        $pdf = Pdf::loadView('fatura', compact('fatura'));
        $pdf = $pdf->setPaper('a4', 'landscape');
        return $pdf->download("fatura-$fatura->id.pdf");
    }

    public function faturar()
    {
        $clientes = Clientes::whereHas('servicos', function ($query) {
            $query->whereNull('fatura_id');
        })->get();

        $chave_pix = Fatura::whereNotNull('chave_pix')
            ->orderBy('created_at', 'desc')
            ->value('chave_pix');

        $data_inicial = Carbon::now()->subDays(30)->format('Y-m-d');
        $data_final = Carbon::now()->format('Y-m-d');

        return Inertia::render('Dashboard/Fatura/Geracoes/Faturar', compact('clientes', 'chave_pix', 'data_inicial', 'data_final'));
    }

    public function gerarFatura(Request $request)
    {
        $fatura = Fatura::create([
            'data_vencimento' => $request->vencimento,
            'data_emissao' => Carbon::now(),
            'valor' => 0,
            'chave_pix' => $request->chave_pix,
            'status' => FaturaEnum::Aberta,
            'cliente_id' => $request->cliente_id,
        ]);
        $valor = 0;
        for ($i = 0; $i < count($request->servicos); $i++) {
            Servicos::find($request->servicos[$i]['id'])->update([
                'fatura_id' => $fatura->id,
            ]);

            $servicos = Servicos::with('analises')->find($request->servicos[$i]['id']);
            $valor += $servicos->analises->sum('price');
        }

        $fatura->valor = $valor;
        $fatura->save();
        return redirect()->route('dashboard.fatura.faturas');
    }

    public function faturaServico(int $id)
    {
        $fatura = Fatura::with(['servicos', 'cliente', 'servicos.analises', 'servicos.analises.categoriaAnalise'])->find($id);

        return Inertia::render('Dashboard/Fatura/Faturas/Servicos', compact('fatura'));
    }

    public function baixarFatura(int $id)
    {
        $fatura = Fatura::with(['servicos', 'cliente'])->find($id);

        return Inertia::render('Dashboard/Fatura/Faturas/Baixa', compact('fatura'));
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
        $faturas = Fatura::with(['servicos', 'cliente'])->paginate(10);
        $status = FaturaEnum::toArray();
        return Inertia::render('Dashboard/Fatura/Faturas/BaixaFatura', compact('faturas', 'status'));
    }
}
