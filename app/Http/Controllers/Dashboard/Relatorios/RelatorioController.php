<?php

namespace App\Http\Controllers\Dashboard\Relatorios;

use App\Enums\Financeiro\CategoriaAnaliseEnum;
use App\Http\Controllers\Controller;
use App\Models\Faturas\Fatura;
use App\Models\Lancamentos\Lancamento;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class RelatorioController extends Controller
{
    public function analiseFinanceira()
    {
        $startDate = '2023-01-01';
        $endDate = '2023-07-31';

        $pagamentos = Lancamento::with(['pagamento.subcategoria.categoria'])
            ->select(
                'categorias.nome as categoria',
                'subcategorias.nome as subcategoria',
                DB::raw('SUM(lancamentos.valor) as total_pago'),
                DB::raw('SUM(lancamentos.valor) / (SELECT SUM(valor) FROM lancamentos WHERE status = "Pago" AND vencimento BETWEEN "' . $startDate . '" AND "' . $endDate . '") * 100 as impacto')
            )
            ->join('pagamentos', 'lancamentos.pagamento_lancamento_id', '=', 'pagamentos.id')
            ->join('subcategorias', 'pagamentos.subcategoria_id', '=', 'subcategorias.id')
            ->join('categorias', 'subcategorias.categoria_id', '=', 'categorias.id')
            ->where('lancamentos.status', 'Pago')
            ->whereBetween('lancamentos.vencimento', [$startDate, $endDate])
            ->groupBy('categorias.nome', 'subcategorias.nome')
            ->orderBy('categorias.nome')
            ->orderBy('subcategorias.nome')
            ->get();

        $resultado = $pagamentos->groupBy('categoria')->map(function ($items, $categoria) {
            $total_categoria = $items->sum('total_pago');
            $impacto = $items->sum('impacto');

            return [
                'total_categoria' => $total_categoria,
                'nome' => $categoria,
                'subcategorias' => $items->map(function ($item) {
                    return [
                        'nome' =>  $item['subcategoria'],
                        'valor' => round($item['total_pago']),
                        'impacto' => round($item['impacto'], 2)
                    ];
                }),
                'impacto' => round($impacto, 2),
            ];
        });

        $pagamentos = [
            'categorias' => $resultado,
            'total_geral' => $resultado->sum('total_categoria')
        ];

        return Inertia::render('Dashboard/Relatorios/AnaliseFinanceira', compact('pagamentos'));
    }

    public function evolucaoFinanceira()
    {
        $year = date('Y');
        $month = date('m');

        $query = Fatura::query()
            ->whereYear('data_emissao', $year)
            ->whereMonth('data_emissao', $month)
            ->get();

        $evolucao_receita = [];
        foreach ($query as $fatura) {
            foreach ($fatura->servicos as $servico) {
                foreach ($servico->analises as $analise) {
                    if (!$analise->categoriaAnalise) {
                        return redirect()->back()->with('mensagem', [
                            'tipo' => 'error',
                            'class' => 'text-danger',
                            'conteudo' => 'Nem todas analises tem categoria definida!'
                        ]);
                    }
                    $category = $analise->categoriaAnalise->categoria;
                    $month = $fatura->data_emissao->format('m');

                    if (!isset($evolucao_receita[$category])) {
                        $evolucao_receita[$category] = array_fill(1, 12, 0);
                    }

                    $evolucao_receita[$category][(int)$month] += $analise->price;
                }
            }
        }

        $categorias = CategoriaAnaliseEnum::toArray();

        return Inertia::render('Dashboard/Relatorios/EvolucaoFinanceira', compact('evolucao_receita', 'categorias'));
    }

    public function rankingClientes()
    {
        return Inertia::render('Dashboard/Relatorios/RankingClientes');
    }

    public function servicos()
    {
        $lastSixMonths = DB::connection('pgsql')->select("
            select count(*) as total, extract(month from created_at) as month,
                trim(to_char(created_at, 'month')) as month_name
            from labs_petrequest
            where created_at > now() - interval '6 months'
            group by month, month_name
            order by month asc");

        return response()->json($lastSixMonths);
    }

    public function servicosFaturamento()
    {
        $lastSixMonthsRevenue = DB::connection('pgsql')->select("
            select
                extract(month from pr.created_at) as month,
                trim(to_char(pr.created_at, 'month')) as month_name,
                sum(a.price) as total
            from labs_petrequest pr
            inner join labs_petrequest_analyse pra on pr.id = pra.petrequest_id
            inner join labs_analyze a on pra.analyze_id = a.id
            where
                pr.created_at > now() - interval '6 months'
            group by
                month, month_name
            order by
                month asc");
        return response()->json($lastSixMonthsRevenue);
    }
}
