<?php

namespace App\Models\Financeiro;

use App\Enums\Financeiro\CategoriaPagamento;
use App\Models\Gerais\Fornecedor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagamentoFornecedor extends Model
{
    use HasFactory;

    protected $table = 'pagamento_fornecedores';

    protected $fillable = [
        'fornecedor_id',
        'descricao',
        'categoria',
    ];

    protected $casts = [
        'categoria' => CategoriaPagamento::class,
        'created_at' => 'datetime:d/m/Y H:i',
        'updated_at' => 'datetime:d/m/Y H:i',
    ];

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class, 'fornecedor_id');
    }
}
