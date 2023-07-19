<?php

namespace App\Models\Financeiro;

use App\Models\Financeiro\Categorias\Categoria;
use App\Models\Financeiro\Categorias\Subcategoria;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receita extends Model
{
    use HasFactory;

    protected $table = 'receitas';

    protected $fillable = [
        'descricao',
        'categoria_id',
        'subcategoria_id',
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i',
        'updated_at' => 'datetime:d/m/Y H:i',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id',);
    }

    public function subcategoria()
    {
        return $this->belongsTo(Subcategoria::class, 'subcategoria_id',);
    }
}
