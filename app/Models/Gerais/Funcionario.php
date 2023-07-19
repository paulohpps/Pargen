<?php

namespace App\Models\Gerais;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    protected $table = 'funcionarios';

    protected $fillable = [
        'nome',
        'cpf',
        'cargo',
        'valor_vencimento',
        'encargos',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'custo_total'
    ];

    public function getCustoTotalAttribute()
    {
        $valorVencimento = $this->toFloat($this->valor_vencimento);
        $encargos = $this->toFloat($this->encargos);
        $custoTotal = $valorVencimento + $encargos;

        return number_format($custoTotal, 2, ',', '.');
    }

    public function getEncargosAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }

    public function getValorVencimentoAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }

    public function getCpfAttribute($value)
    {
        return substr($value, 0, 3) . '.' . substr($value, 3, 3) . '.' . substr($value, 6, 3) . '-' . substr($value, 9, 2);
    }


    private function toFloat($str)
    {
        $str = str_replace('.', '', $str); // Remove os pontos (separadores de milhar)
        $str = str_replace(',', '.', $str); // Substitui a vírgula por ponto (separador decimal)
        return floatval($str);
    }
}
