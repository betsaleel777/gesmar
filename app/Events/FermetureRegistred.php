<?php

namespace App\Events;

use App\Models\Caisse\Fermeture;
use Illuminate\Foundation\Events\Dispatchable;

class FermetureRegistred
{
    use Dispatchable;

    public function __construct(public Fermeture $fermeture)
    {
    }
}
