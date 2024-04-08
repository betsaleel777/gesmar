<?php

namespace App\Events;

use App\Enums\StatusFacture;
use App\Models\Finance\Facture;
use Illuminate\Foundation\Events\Dispatchable;

class FactureStatusChange
{
    use Dispatchable;

    public function __construct(public Facture $facture, public StatusFacture $status)
    {
    }
}
