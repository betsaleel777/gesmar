<?php

namespace App\Events;

use App\Models\Exploitation\Contrat;
use Illuminate\Foundation\Events\Dispatchable;

class ContratScheduled
{
    use Dispatchable;

    public function __construct(public Contrat $contrat)
    {
    }
}
