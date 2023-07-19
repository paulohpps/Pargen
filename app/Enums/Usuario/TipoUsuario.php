<?php

namespace App\Enums\Usuario;

use App\Enums\EnumToArray;

enum TipoUsuario: int
{
    use EnumToArray;
    case Usuario = 0;
    case Admin = 1;
}
