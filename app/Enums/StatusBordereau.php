<?php

namespace App\Enums;

enum StatusBordereau: string
{
    case ENCAISSE = 'encaissé';
    case PAS_ENCAISSE = 'non encaissé';
}
