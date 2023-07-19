<?php

namespace App\Enums\Financeiro;

use App\Enums\EnumToArray;

enum ClienteCategoriaEnum: int
{
    use EnumToArray;
    case AVista = 0;
    case SemanalPix = 1;
    case SemanalBoleto  = 2;
    case MensalPix = 3;
    case MensalBoleto = 4;

    public static function names(): array
    {
        return [
            self::AVista->value => 'A Vista',
            self::SemanalPix->value => 'Semanal Pix',
            self::SemanalBoleto->value => 'Semanal Boleto',
            self::MensalPix->value => 'Mensal Pix',
            self::MensalBoleto->value => 'Mensal Boleto',
        ];
    }
}
