<?php

namespace App\Models\Imports;

use App\Models\AnaliseServicos;
use App\Models\CategoriaAnalise;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analises extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';

    protected $table = 'labs_analyze';

    protected $fillable = [
        'id',
        'name',
        'price',
    ];

    public function getPriceAttribute($value)
    {
        return floatval($value);
    }

    public function categoriaAnalise()
    {
        return $this->hasOne(CategoriaAnalise::class, 'id_analise', 'id');
    }

    public function analiseServico()
    {
        return $this->hasMany(AnaliseServicos::class, 'analyze_id', 'id');
    }
}
