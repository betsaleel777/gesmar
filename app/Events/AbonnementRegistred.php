<?php

namespace App\Events;

use App\Models\Architecture\Abonnement;
use Illuminate\Foundation\Events\Dispatchable;

class AbonnementRegistred
{
    use Dispatchable;

    public function __construct(public Abonnement $abonnement)
    {
    }
}
