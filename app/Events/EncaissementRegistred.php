<?php

namespace App\Events;

use App\Models\Caisse\Encaissement;
use Illuminate\Foundation\Events\Dispatchable;

class EncaissementRegistred
{
    use Dispatchable;

    public function __construct(public Encaissement $encaissement)
    {
    }
}
