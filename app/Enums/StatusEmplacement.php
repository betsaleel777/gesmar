<?php

namespace App\Enums;

enum StatusEmplacement: string
{
    case BUSY = 'occupé';
    case FREE = 'libre';
    case LINKED = 'lié';
    case UNLINKED = 'non lié';
}
