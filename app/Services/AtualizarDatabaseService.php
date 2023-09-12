<?php

namespace App\Services;

use App\Models\Imports\Analises;
use App\Models\Imports\AnaliseServicos;
use App\Models\Imports\Clientes;
use App\Models\Imports\Servicos;
use Illuminate\Support\Facades\Http;

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
            ->get('https://app.ontrace.com.br/api/v1/clientes/');

        $clientes = $response->json();
        foreach ($clientes as $cliente) {
            Clientes::updateOrCreate(
                ['id' => $cliente['id']],
                $cliente
            );
        }
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
    }

    private static function atualizarServicos()
    {
        $response = Http::withHeaders(['Token' => env('TOKEN_API_ON_TRACE')])
            ->timeout(-1)
            ->get('https://app.ontrace.com.br/api/v1/requisicoes/');

        $requisicoes = $response->json();
        foreach ($requisicoes as $requisicao) {
            Servicos::updateOrCreate(
                ['id' => $requisicao['id']],
                $requisicao
            );

            foreach ($requisicao['analyse'] as $analise) {
                AnaliseServicos::updateOrCreate(
                    ['petrequest_id' => $requisicao['id']],
                    [
                        'analyze_id' => $analise,
                        'petrequest_id' => $requisicao['id'],
                    ]
                );
            }
        }
    }
}
