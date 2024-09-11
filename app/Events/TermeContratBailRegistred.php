<?php

namespace App\Events;

use App\Models\Template\TermesContratEmplacement;
use Illuminate\Foundation\Events\Dispatchable;

class TermeContratBailRegistred
{
    use Dispatchable;

    public function __construct(public TermesContratEmplacement $terme)
    {
        $this->terme = $terme;
    }
}
