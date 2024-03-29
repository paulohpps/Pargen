<?php

namespace App\Models\Imports;

use App\Models\ClienteCategoria;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;

    protected $table = 'labs_customer';

    protected $fillable = [
        'id',
        'is_active',
        'create_at',
        'updated_at',
        'name',
        'sexo',
        'cnpj_cpf',
        'email',
        'phone',
        'address',
        'number',
        'area',
        'city',
        'state',
        'complement',
        'obs',
        'lab',
        'state_registration_rg',
        'customer_type',
        'birthday',
        'zip_code',
        'oficial_depart_number',
        'oficial_service_vet',
        'trading_name',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'date:d/m/Y',
        'updated_at' => 'date:d/m/Y',
    ];

    public function clienteCategoria()
    {
        return $this->hasOne(ClienteCategoria::class, 'id_cliente');
    }

    public function servicos()
    {
        return $this->hasMany(Servicos::class, 'customer', 'id');
    }
}
