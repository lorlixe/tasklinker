<?php

namespace App\Enum;

enum Contrat: string
{
    case cdd = 'CDD';
    case cdi = 'CDI';

    public function getLabel(): string
    {
        return match ($this) {
            self::cdd => 'CDD',
            self::cdi => 'CDI',
        };
    }
}
