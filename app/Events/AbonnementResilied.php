<?php

namespace App\Events;

use App\Models\Architecture\Abonnement;
use Illuminate\Foundation\Events\Dispatchable;

class AbonnementResilied
{
    use Dispatchable;

    public function __construct(public Abonnement $abonnement)
    {
    }
}
