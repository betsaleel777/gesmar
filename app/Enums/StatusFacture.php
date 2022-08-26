<?php

namespace App\Enums;

enum StatusFacture: string
{
    case PAID = 'soldée';
    case UNPAID = 'à solder';
    case FACTURE = 'facture';
    case PROFORMA = 'proforma';
}
