<?php

namespace App\Enums;

enum StatusReparation: string {
    case PENDING = 'en attente';
    case PROGRESSING = 'en cours';
    case FINISHED = 'terminée';
}
