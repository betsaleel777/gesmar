<?php

namespace App\Enums;

enum StatusAbonnement: string
{
    case PROGRESSING = 'en cours';
    case STOPPED = 'résilié';
}
