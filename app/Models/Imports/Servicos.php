<?php

namespace App\Models\Imports;

use App\Models\Faturas\FaturaServico;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicos extends Model
{
    use HasFactory;

    protected $table = 'labs_petrequest';

    protected $connection = 'pgsql';

    protected  $fillable = [
        'id',
        'is_active',
        'create_at',
        'updated_at',
        'collect_date',
        'collect_hour',
        'customer_id',
        'lab_id',
        'pet',
        'tutor',
        'requester_id',
        'request_number',
        'status',
        'specie_id',
        'collected',
        'vet_requester',
        'age_month',
        'age_year',
        'breed',
        'gender',
        'collected_date',
    ];

    protected $casts = [
        'create_at' => 'date:d/m/Y',
        'updated_at' => 'date:d/m/Y',
        'collect_date' => 'date:d/m/Y',
    ];

    public function analises()
    {
        return $this->belongsToMany(
            Analises::class,
            'labs_petrequest_analyse',
            'petrequest_id',
            'analyze_id'
        );
    }

    protected $hidden = [
        'faturaServico'
    ];

    public function faturaServico()
    {
        return $this->hasOne(FaturaServico::class, 'servico_id', 'id');
    }

    public function getFaturaAttribute()
    {
        return optional($this->faturaServico)->fatura;
    }

    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'customer_id', 'id');
    }
}
