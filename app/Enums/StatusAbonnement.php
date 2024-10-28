<?php

namespace App\Enums;

enum StatusAbonnement: string
{
    case PROGRESSING = 'en cours';
    case STOPPED = 'résilié';
    case ERROR = 'erreur index';
    case EN_ATTENTE = 'en attente';
}
