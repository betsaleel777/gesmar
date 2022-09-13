<?php

namespace App\Enums;

enum StatusOrdonnancement: string
{
    case PAID = 'payé';
    case UNPAID = 'impayé';
}
