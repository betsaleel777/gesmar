<?php

namespace App\Enums;

enum StatusEncaissement: string
{
    case CLOSED = 'fermé';
    case OPENED = 'ouvert';
}
