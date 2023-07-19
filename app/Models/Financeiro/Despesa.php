<?php

namespace App\Models\Financeiro;

use App\Enums\Financeiro\CategoriaPagamento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Despesa extends Model
{
    use HasFactory;

    protected $table = 'despesas';

    protected $fillable = [
        'descricao',
        'categoria_pagamento',
    ];

    protected $casts = [
        'categoria_pagamento' => CategoriaPagamento::class,
    ];
}
