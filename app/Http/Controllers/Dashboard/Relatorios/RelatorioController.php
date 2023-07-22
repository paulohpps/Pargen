<?php

namespace App\Http\Controllers\Dashboard\Relatorios;

use App\Enums\Financeiro\CategoriaAnaliseEnum;
use App\Http\Controllers\Controller;
use App\Models\Faturas\Fatura;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class RelatorioController extends Controller
{
    public function analiseFinanceira()
    {
        return Inertia::render('Dashboard/Relatorios/AnaliseFinanceira');
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
       /* return response()->json([
            'evolucao_receita' => $evolucao_receita,
            'categorias' => $categorias
        ]);*/

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
