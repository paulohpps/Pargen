<?php

namespace App\Models\Lancamentos;

use App\Models\Financeiro\Categorias\Categoria;
use App\Models\Financeiro\Categorias\Subcategoria;
use App\Models\Financeiro\Pagamento;
use App\Models\Gerais\Fornecedor;
use App\Models\Gerais\Funcionario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lancamento extends Model
{
    use HasFactory;

    protected  $fillable = [
        'tipo_pagamento',
        'pago_para',
        'fornecedor_id',
        'funcionario_id',
        'pagamento_lancamento_id',
        'descricao',
        'valor',
        'vencimento',
        'status',
    ];

    protected $casts = [
        'created_at' => 'date:d/m/Y',
        'updated_at' => 'date:d/m/Y',
        'vencimento' => 'date:d/m/Y',
    ];

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class, 'fornecedor_id');
    }

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'funcionario_id');
    }

    public function pagamento()
    {
        return $this->belongsTo(Pagamento::class, 'pagamento_lancamento_id');
    }
}
