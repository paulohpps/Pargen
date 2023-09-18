<?php

namespace App\Services;

use App\Models\CategoriaAnalise;
use App\Models\ClienteCategoria;
use App\Models\Faturas\Fatura;
use App\Models\Imports\Analises;
use App\Models\Imports\AnaliseServicos;
use App\Models\Imports\Clientes;

class FiltragemServicos
{
    public static function filtrarServicos($servicos, $request)
    {
        if($request->input('paciente')) {
            $servicos = self::filtraPorPaciente($servicos, $request->input('paciente'));
        }
        if ($request->input('cliente')) {
            $servicos = self::filtraPorCliente($servicos, $request->input('cliente'));
        }
        if ($request->input('numero_fatura')) {
            $servicos = self::filtraPorNumeroFatura($servicos, $request->input('numero_fatura'));
        }
        if ($request->input('numero_amostra')) {
            $servicos = self::filtraPorNumeroAmostra($servicos, $request->input('numero_amostra'));
        }
        if ($request->input('analise')) {
            $servicos = self::filtraPorAnalise($servicos, $request->input('analise'));
        }
        if ($request->input('categoria_analise') != '') {
            $servicos = self::filtraPorCategoriaAnalise($servicos, $request->input('categoria_analise'));
        }
        if ($request->input('tipo_cliente') != '') {
            $servicos = self::filtraPorTipoCliente($servicos, $request->input('tipo_cliente'));
        }
        if ($request->input('data_coleta')) {
            $servicos = self::filtraPorDataColeta($servicos, $request->input('data_coleta'));
        }
        if ($request->input('data_vencimento')) {
            $servicos = self::filtraPorDataVencimento($servicos, $request->input('data_vencimento'));
        }
        if ($request->input('data_recebimento')) {
            $servicos = self::filtraPorDataRecebimento($servicos, $request->input('data_recebimento'));
        }

        return $servicos;
    }

    public static function filtraPorPaciente($servicos, $nome_paciente)
    {
        return $servicos->where('pet', 'like', '%' . $nome_paciente . '%');
    }

    public static function filtraPorCliente($servicos, $nome_cliente)
    {
        $clientes = Clientes::where('name', $nome_cliente)
            ->orWhere('name', 'like', '%' . $nome_cliente . '%')->get();

        return $servicos->whereIn('customer', $clientes);
    }

    public static function filtraPorNumeroFatura($servicos, $numero_fatura)
    {
        return $servicos->where('fatura_id', $numero_fatura);
    }

    public static function filtraPorNumeroAmostra($servicos, $numero_amostra)
    {
        return $servicos->where('request_number', $numero_amostra);
    }

    public static function filtraPorAnalise($servicos, $analise)
    {
        $analise_servico = AnaliseServicos::where('id', $analise)->first();
        return $servicos->where('id', $analise_servico->petrequest_id);
    }

    public static function filtraPorCategoriaAnalise($servicos, $categoria_analise)
    {
        $categoria = CategoriaAnalise::where('categoria', $categoria_analise)->first();
        $analise = Analises::where('id', $categoria->id_analise)->first();
        $analise_servico = AnaliseServicos::where('analyze_id', $analise->id)->first();
        return $servicos->whereIn('id', $analise_servico->petrequest_id);
    }

    public static function filtraPorTipoCliente($servicos, $tipo_cliente)
    {
        $categoria_cliente = ClienteCategoria::where('categoria', $tipo_cliente)->get();
        $clientes = Clientes::whereIn('id', $categoria_cliente->id_cliente)->get();
        return $servicos->whereIn('customer', $clientes);
    }

    public static function filtraPorDataColeta($servicos, $data_coleta)
    {
        return $servicos->where('collect_date', $data_coleta);
    }

    public static function filtraPorDataVencimento($servicos, $data_vencimento)
    {
        $fatura = Fatura::where('data_vencimento', $data_vencimento)->first();
        return $servicos->where('fatura_id', $fatura->id);
    }

    public static function filtraPorDataRecebimento($servicos, $data_recebimento)
    {
        $fatura = Fatura::where('data_baixa', $data_recebimento)->first();
        return $servicos->where('fatura_id', $fatura->id);
    }

}
