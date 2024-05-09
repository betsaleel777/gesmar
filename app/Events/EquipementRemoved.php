<?php

namespace App\Events;

use App\Models\Architecture\Equipement;
use Illuminate\Foundation\Events\Dispatchable;

class EquipementRemoved
{
    use Dispatchable;

    public function __construct(public Equipement $equipement)
    {
        $this->equipement = $equipement;
    }
}
