<?php

namespace App\Models\Faturas;

use App\Enums\Financeiro\FaturaEnum;
use App\Models\Imports\Servicos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Fatura extends Model
{
    use HasFactory;

    protected $table = 'faturas';

    protected $connection = 'mysql';

    protected $fillable = [
        'data_vencimento',
        'data_emissao',
        'data_baixa',
        'cliente_id',
        'status',
        'chave_pix',
        'valor',
        'valor_pago',
    ];

    protected $appends = [
        'servicos',
    ];

    protected $casts = [
        'data_vencimento' => 'date:d/m/Y',
        'data_emissao' => 'date:d/m/Y',
        'data_baixa' => 'date:d/m/Y',
        'status' => FaturaEnum::class,
    ];

    protected $hidden = [
        'fatura_servico'
    ];

    public function fatura_servico()
    {
        return $this->hasMany(FaturaServico::class);
    }

    public function getServicosAttribute()
    {
        return $this->fatura_servico()->with(['servico', 'servico.cliente', 'servico.analises'])->get()->map(function ($faturaServico) {
            return $faturaServico->servico;
        });
    }
}
