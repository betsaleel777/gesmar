<?php

namespace App\Enums;

enum StatusFermeture: string {
    case PENDING = 'en attente';
    case WITHLOSS = 'validé avec perte';
    case WITHOUTLOSS = 'validé sans perte';
}
