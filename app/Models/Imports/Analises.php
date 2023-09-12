<?php

namespace App\Models\Imports;

use App\Models\CategoriaAnalise;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analises extends Model
{
    use HasFactory;

    protected $table = 'labs_analyze';

    protected $fillable = [
        'id',
        'is_active',
        'created_at',
        'updated_at',
        'name',
        'slug',
        'price',
        'deadline',
        'description',
        'reference',
        'default',
        'order',
        'lab',
        'category'
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
