<?php

namespace App\Models\Financeiro;

use App\Enums\Financeiro\CategoriaPagamento;
use App\Models\Gerais\Funcionario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagamentoFuncionario extends Model
{
    use HasFactory;

    protected $table = 'pagamento_funcionarios';

    protected $fillable = [
        'funcionario_id',
        'descricao',
        'categoria',
    ];

    protected $casts = [
        'categoria' => CategoriaPagamento::class,
        'created_at' => 'datetime:d/m/Y H:i',
        'updated_at' => 'datetime:d/m/Y H:i',
    ];

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'funcionario_id');
    }
}
