<?php

namespace App\Events;

use App\Models\Caisse\Fermeture;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Request;

class FermetureValidated
{
    use Dispatchable;

    public function __construct(public Fermeture $fermeture, public Request $payload)
    {

    }
}
