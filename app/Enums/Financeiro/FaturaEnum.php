<?php

namespace App\Enums\Financeiro;

use App\Enums\EnumToArray;

enum FaturaEnum: int
{
    use EnumToArray;
    case Aberta = 0;
    case Paga = 1;
    case Cancelada = 2;
    case Atrasada = 3;
    case Pago_Parcial = 4;

    public static function names(): array
    {
        return [
            self::Aberta->value => 'Aberta',
            self::Paga->value => 'Paga',
            self::Cancelada->value => 'Cancelada',
            self::Atrasada->value => 'Atrasada',
            self::Pago_Parcial->value => 'Pago Parcial',
        ];
    }
}
