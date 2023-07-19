<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\Financeiro\CategoriaAnaliseEnum;
use App\Enums\Financeiro\FaturaEnum;
use App\Http\Controllers\Controller;
use App\Models\AnaliseServicos;
use App\Models\Faturas\Fatura;
use App\Models\Faturas\FaturaServico;
use App\Models\Imports\Analises;
use App\Models\Imports\Servicos;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class FaturaController extends Controller
{
    public function home()
    {
        $servicos = Servicos::with('analises')->paginate(10);
        $analises = Analises::with('categoriaAnalise')->get();
        $categorias = CategoriaAnaliseEnum::toArray();
        return Inertia::render('Dashboard/Fatura/Geracoes/Listagem', compact('servicos', 'analises', 'categorias'));
    }

    public function faturas()
    {
        $faturas = Fatura::paginate(10);
        //$faturas->append('servicos');
        $status = FaturaEnum::toArray();
        return Inertia::render('Dashboard/Fatura/Faturas/Listagem', compact('faturas', 'status'));
    }

    public function fatura(int $id)
    {
        $fatura = Fatura::find($id);
        $fatura->append('servicos');
        $pdf = Pdf::loadView('fatura', compact('fatura'));
        $pdf = $pdf->setPaper('a4', 'landscape');
        return $pdf->stream("fatura.pdf");
    }

    public function faturar()
    {
        return Inertia::render('Dashboard/Fatura/Geracoes/Faturar');
    }

    public function gerarFatura(Request $request)
    {
        $fatura = Fatura::create([
            'data_vencimento' => Carbon::now()->addDays(10),
            'data_emissao' => Carbon::now(),
            'valor' => 500.00,
            'status' => FaturaEnum::Aberta,
            'cliente_id' => 1,
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
        return redirect()->route('dashboard.fatura');
    }

    public function faturaServico(int $id)
    {
        $fatura = Fatura::find($id);
        $fatura->append('servicos');
        $analises_servicos = AnaliseServicos::with('analise')->where('petrequest_id', $fatura->fatura_servico[0]->servico->id)->get();
        $analises = Analises::with('categoriaAnalise')->get();

        return Inertia::render('Dashboard/Fatura/Faturas/Servicos', compact('fatura', 'analises_servicos', 'analises'));
    }

    public function baixarFatura(int $id)
    {
        $fatura = Fatura::find($id);
        $fatura->status = FaturaEnum::Paga;
        $fatura->save();

        return redirect()->back();
    }

    public function faturasBaixa()
    {
        $faturas = Fatura::with(['fatura_servico', 'fatura_servico.servico'])->paginate(10);
        $status = FaturaEnum::toArray();
        return Inertia::render('Dashboard/Fatura/Faturas/BaixaFatura', compact('faturas', 'status'));
    }
}
