<?php

namespace App\Enums;

enum StatusValidationAbonnement: string
{
    case UNVALIDATED = 'non validé';
    case VALIDATED = 'validé';
}
