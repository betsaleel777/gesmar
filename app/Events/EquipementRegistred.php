<?php

namespace App\Events;

use App\Models\Architecture\Equipement;
use Illuminate\Foundation\Events\Dispatchable;

class EquipementRegistred
{
    use Dispatchable;

    public function __construct(public Equipement $equipement, public int $ancienEmplacement = 0)
    {
    }
}
