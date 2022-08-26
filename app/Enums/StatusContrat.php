<?php

namespace App\Enums;

enum StatusContrat: string
{
    case VALIDATED = 'validé';
    case ONENDORSED = 'à signer';
    case ONVALIDATED = 'à valider';
    case ATTENTE = 'en attente';
}
