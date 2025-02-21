<?php

namespace App\Enum;

enum Contrat: string
{
    case cdd = 'CDD';
    case cdi = 'CDI';
    case freelance = 'Freelance';


    public function getLabel(): string
    {
        return match ($this) {
            self::cdd => 'CDD',
            self::cdi => 'CDI',
            self::freelance => 'Freelance',
        };
    }
}
