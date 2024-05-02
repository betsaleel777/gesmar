<?php

namespace App\Events;

use App\Models\Exploitation\Contrat;
use Illuminate\Foundation\Events\Dispatchable;

class ContratRegistred
{
    use Dispatchable;

    public function __construct(public Contrat $contrat, public int $avance = 0, public int $montantAnnexe = 0)
    {
    }
}
