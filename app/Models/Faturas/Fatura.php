<?php

namespace App\Models\Faturas;

use App\Enums\Financeiro\FaturaEnum;
use App\Models\Imports\Clientes;
use App\Models\Imports\Servicos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Fatura extends Model
{
    use HasFactory;

    protected $table = 'faturas';

    protected $fillable = [
        'data_vencimento',
        'data_emissao',
        'data_baixa',
        'cliente_id',
        'status',
        'chave_pix',
        'valor',
        'valor_pago',
        'observacao'
    ];

    protected $casts = [
        'data_vencimento' => 'date:d/m/Y',
        'data_emissao' => 'date:d/m/Y',
        'data_baixa' => 'date:d/m/Y',
        'status' => FaturaEnum::class,
    ];

    public function servicos()
    {
        return $this->hasMany(Servicos::class, 'fatura_id', 'id');
    }

    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'cliente_id', 'id');
    }
}
