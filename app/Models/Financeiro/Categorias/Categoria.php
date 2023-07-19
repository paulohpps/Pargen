<?php

namespace App\Models\Financeiro\Categorias;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'nome',
    ];

    public function subcategorias()
    {
        return $this->hasMany(Subcategoria::class);
    }
}