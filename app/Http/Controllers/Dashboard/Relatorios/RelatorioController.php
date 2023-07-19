<?php

namespace App\Http\Controllers\Dashboard\Relatorios;

use App\Http\Controllers\Controller;
use App\Models\CategoriaAnalise;
use App\Models\Faturas\Fatura;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class RelatorioController extends Controller
{
    public function analiseFinanceira()
    {
        return Inertia::render('Dashboard/Relatorios/AnaliseFinanceira');
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
