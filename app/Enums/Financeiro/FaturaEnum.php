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
}
