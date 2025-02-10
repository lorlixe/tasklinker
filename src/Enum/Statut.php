<?php

namespace App\Enum;

enum Statut: string
{
    case to_do = 'To Do';
    case doing = 'Doing';
    case done = 'Done';


    public function getLabel(): string
    {
        return match ($this) {
            self::to_do => 'To Do',
            self::doing => 'Doing',
            self::done => 'Done',
        };
    }
}
