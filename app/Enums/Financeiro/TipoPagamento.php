<?php

namespace App\Enums\Financeiro;

use App\Enums\EnumToArray;

enum TipoPagamento: int
{
    use EnumToArray;
    case Despesas = 0;
    case Fornecedores = 1;
    case Funcionários = 2;
}
