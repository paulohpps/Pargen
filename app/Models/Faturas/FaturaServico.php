<?php

namespace App\Models\Faturas;

use App\Models\Imports\Servicos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaturaServico extends Model
{
    use HasFactory;

    protected $table = 'fatura_servicos';

    protected $connection = 'mysql';

    protected $fillable = [
        'fatura_id',
        'servico_id',
    ];

    public function fatura()
    {
        return $this->belongsTo(Fatura::class, 'fatura_id');
    }

    public function servico()
    {
        return $this->belongsTo(Servicos::class, 'servico_id', 'id', 'pgsql');
    }
}
