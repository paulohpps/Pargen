<?php

namespace App\Services;

use App\Models\Faturas\Fatura;
use App\Models\Imports\Analises;
use App\Models\Imports\AnaliseServicos;
use App\Models\Imports\Clientes;
use App\Models\Imports\Servicos;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AtualizarDatabaseService
{
    public static function atualizar()
    {
        AtualizarDatabaseService::atualizarClientes();
        AtualizarDatabaseService::atualizarAnalises();
        AtualizarDatabaseService::atualizarServicos();
    }

    private static function atualizarClientes()
    {
        $response = Http::withHeaders(['Token' => env('TOKEN_API_ON_TRACE')])
            ->timeout(-1)
            ->get(env('API_URL'));

        $clientes = $response->json();
        foreach ($clientes as $cliente) {
            Clientes::updateOrCreate(
                ['id' => $cliente['id']],
                $cliente
            );
        }

        Log::info('Clientes atualizados com sucesso');
    }

    private static function atualizarAnalises()
    {
        $response = Http::withHeaders(['Token' => env('TOKEN_API_ON_TRACE')])
            ->timeout(-1)
            ->get('https://app.ontrace.com.br/api/v1/analises/');

        $analises = $response->json();
        foreach ($analises as $analise) {
            Analises::updateOrCreate(
                ['id' => $analise['id']],
                $analise
            );
        }

        Log::info('Análises atualizadas com sucesso');
    }

    private static function atualizarServicos()
    {
        $response = Http::withHeaders(['Token' => env('TOKEN_API_ON_TRACE')])
            ->timeout(-1)
            ->get('https://app.ontrace.com.br/api/v1/requisicoes/pets/');

        $requisicoes = $response->json();
        foreach ($requisicoes as $requisicao) {

            $requisicao['collected_date'] = Carbon::parse($requisicao['collected_date'])->format('Y-m-d');
            $requisicao['created_at'] = Carbon::parse($requisicao['created_at'])->format('Y-m-d');
            $requisicao['updated_at'] = Carbon::parse($requisicao['updated_at'])->format('Y-m-d');

            Servicos::updateOrCreate(
                ['id' => $requisicao['id']],
                $requisicao
            );

            foreach ($requisicao['analyse'] as $analise) {
                AnaliseServicos::firstOrCreate(
                    ['analyze_id' => $analise, 'petrequest_id' => $requisicao['id']],
                    ['analyze_id' => $analise, 'petrequest_id' => $requisicao['id']]
                );
            }

            AnaliseServicos::where('petrequest_id', $requisicao['id'])->whereNotIn('analyze_id', $requisicao['analyse'])->delete();
        }

        Log::info('Serviços atualizados com sucesso');

        AtualizarDatabaseService::CorrigirServicosApagados();
    }

    private static function CorrigirServicosApagados()
    {
        AnaliseServicos::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('labs_petrequest')
                ->whereRaw('labs_petrequest.id = labs_petrequest_analyze.petrequest_id')
                ->where('labs_petrequest.status', 'CD');
        })->delete();

        Servicos::where('status', 'CD')->delete();

        $faturas = Fatura::all();

        foreach ($faturas as $fatura) {
            $novoValor = 0;
            foreach ($fatura->servicos as $servico) {
                $novoValor += $servico->analises()->sum('price');
            }
            $fatura->update(['valor' => $novoValor]);
            $fatura->save();
        }

        Log::info('Serviços apagados corrigidos com sucesso');
    }
}
