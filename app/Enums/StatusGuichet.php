<?php

namespace App\Enums;

enum StatusGuichet: string
{
    case OPEN = 'ouvert';
    case CLOSE = 'fermé';
}
