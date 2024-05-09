<?php

namespace App\Events;

use App\Models\Caisse\Ouverture;
use Illuminate\Foundation\Events\Dispatchable;

class OuvertureRegistred
{
    use Dispatchable;

    public function __construct(public Ouverture $ouverture)
    {

    }
}
