<?php

namespace App\Services;

use App\Enums\Financeiro\FaturaEnum;
use App\Models\Faturas\Fatura;

class FaturaService
{
    public static function AtualizarStatus()
    {
        Fatura::where('data_vencimento', '<', now()->format('Y-m-d'))
            ->whereIn('status', [FaturaEnum::Aberta, FaturaEnum::Pago_Parcial])
            ->update(['status' => FaturaEnum::Atrasada]);
    }
}
