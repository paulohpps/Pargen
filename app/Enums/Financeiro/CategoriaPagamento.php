<?php

namespace App\Enums\Financeiro;

use App\Enums\EnumToArray;

enum CategoriaPagamento: int
{
    use EnumToArray;
    case Despesa_Fixa = 0;
    case Despesa_Variável  = 1;
    case Custos_Serviços = 2;
    case Impostos = 3;
    case Pró_Labore = 4;
    case Despesa_Com_Pessoal = 5;
}
