<?php

namespace App\Enums;

enum StatusBordereau: string {
    case CASHED = 'encaissé';
    case UNCASHED = 'non encaissé';
}
