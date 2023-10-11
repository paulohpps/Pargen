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
        if ($request->input('paciente')) {
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
        return $servicos->join('labs_customer', 'labs_petrequest.customer', '=', 'labs_customer.id')
            ->where(function ($query) use ($nome_cliente) {
                $query->where('labs_customer.name', $nome_cliente)
                    ->orWhere('labs_customer.name', 'like', '%' . $nome_cliente . '%');
            })
            ->select('labs_petrequest.*')
            ->distinct();
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
        return $servicos->join('labs_petrequest_analyze', 'labs_petrequest.id', '=', 'labs_petrequest_analyze.petrequest_id')
            ->where('labs_petrequest_analyze.analyze_id', $analise)
            ->select('labs_petrequest.*')
            ->distinct();
    }

    public static function filtraPorCategoriaAnalise($servicos, $categoria_analise)
    {
        return $servicos->join('labs_petrequest_analyze', 'labs_petrequest.id', '=', 'labs_petrequest_analyze.petrequest_id')
            ->join('labs_analyze', 'labs_petrequest_analyze.analyze_id', '=', 'labs_analyze.id')
            ->join('categoria_analises', 'labs_analyze.id', '=', 'categoria_analises.id_analise')
            ->where('categoria_analises.categoria', $categoria_analise)
            ->select('labs_petrequest.*')
            ->distinct();
    }

    public static function filtraPorTipoCliente($servicos, $tipo_cliente)
    {
        return $servicos->join('labs_customer', 'labs_petrequest.customer', '=', 'labs_customer.id')
            ->join('cliente_categorias', 'labs_customer.id', '=', 'cliente_categorias.id_cliente')
            ->where('cliente_categorias.categoria', $tipo_cliente)
            ->select('labs_petrequest.*')
            ->distinct();
    }

    public static function filtraPorDataColeta($servicos, $data_coleta)
    {
        return $servicos->where('collect_date', $data_coleta);
    }

    public static function filtraPorDataVencimento($servicos, $data_vencimento)
    {
        return $servicos->join('faturas as f1', 'labs_petrequest.fatura_id', '=', 'f1.id')
            ->where('f1.data_vencimento', $data_vencimento)
            ->select('labs_petrequest.*')
            ->distinct();
    }

    public static function filtraPorDataRecebimento($servicos, $data_baixa)
    {
        return $servicos->join('faturas as f2', 'labs_petrequest.fatura_id', '=', 'f2.id')
            ->where('f2.data_baixa', $data_baixa)
            ->select('labs_petrequest.*')
            ->distinct();
    }
}
