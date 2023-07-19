<?php

namespace App\Models;

use App\Models\Imports\Analises;
use App\Models\Imports\Servicos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnaliseServicos extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';

    protected $table = 'labs_petrequest_analyse';

    protected $fillable = [
        'id',
        'analyze_id',
        'petrequest_id',
    ];

    public function analise()
    {
        return $this->belongsTo(Analises::class, 'petrequest_id', 'id');
    }

    public function servico()
    {
        return $this->belongsToMany(Servicos::class, 'analyze_id', 'id');
    }
}
