<?php

namespace App\Enums;

enum NaturePaiement: string
{
    case ESPECE = 'Espece';
    case CHEQUE = 'Cheque';
    case WAVE = 'Wave';
    case MOBILE = 'Mobile';
}
