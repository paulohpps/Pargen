<?php

namespace App\Enums\Financeiro;

use App\Enums\EnumToArray;

enum CategoriaAnaliseEnum: int
{
    use EnumToArray;
    case ControleQualideAviario = 0;
    case AnaliseClinicaEmPets = 1;
    case DiagnosticoMolecularPets = 2;

    public static function names(): array
    {
        return [
            self::ControleQualideAviario->value => 'Controle de Qualidade em Aviário',
            self::AnaliseClinicaEmPets->value => 'Análise Clínica em Pets',
            self::DiagnosticoMolecularPets->value => 'Diagnóstico Molecular em Pets',
        ];
    }
}

