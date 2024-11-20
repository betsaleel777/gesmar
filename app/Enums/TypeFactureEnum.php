<?php

namespace App\Enums;

enum TypeFactureEnum: string
{
    case INITIALE = 'initiale';
    case LOYER = 'loyer';
    case EQUIPEMENT = 'equipement';
    case ANNEXE = 'annexe';
    case ABONNEMENT = 'abonnement';
}
