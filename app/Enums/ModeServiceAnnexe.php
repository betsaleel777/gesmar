<?php

namespace App\Enums;

enum ModeServiceAnnexe: string
{
    case MENSUEL = 'par mois';
    case QUOTIDIEN = 'par jour';
    case FORFAIT = 'forfaitaire';
}
