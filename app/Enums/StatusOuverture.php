<?php

namespace App\Enums;

enum StatusOuverture: string {
    case CONFIRMED = 'terminée';
    case USING = 'en cours';
    case CHECKING = 'en examen';
}
