<?php

namespace App\StateMachines;

use App\Enums\StatusCollecte;
use Asantibanez\LaravelEloquentStateMachines\StateMachines\StateMachine;

class BordereauStatusMachine extends StateMachine
{
    public function recordHistory(): bool
    {
        return true;
    }

    public function transitions(): array
    {
        return [
            StatusCollecte::UNCOLLECTED->value => StatusCollecte::COLLECTED->value
        ];
    }

    public function defaultState(): ?string
    {
        return StatusCollecte::UNCOLLECTED->value;
    }
}
