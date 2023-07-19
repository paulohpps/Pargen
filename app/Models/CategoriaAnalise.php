<?php

namespace App\Models;

use App\Models\Imports\Analises;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaAnalise extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $table = 'categoria_analises';

    protected $fillable = [
        'id',
        'id_analise',
        'categoria',
    ];

    public function analiseServico()
    {
        return $this->belongsTo(Analises::class, 'id_analise', 'id');
    }
}
