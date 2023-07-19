<?php

namespace App\Models;

use App\Enums\Financeiro\ClienteCategoriaEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteCategoria extends Model
{
    use HasFactory;

    protected $table = 'cliente_categorias';

    protected $connection = 'mysql';

    protected $fillable = [
        'id_cliente',
        'categoria'
    ];

    protected $casts = [
        'created_at' => 'date:d/m/Y',
        'updated_at' => 'date:d/m/Y',
        'status' => ClienteCategoriaEnum::class,
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
}
