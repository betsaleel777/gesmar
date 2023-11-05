<?php

namespace App\StateMachines;

use App\Enums\StatusBordereau;
use Asantibanez\LaravelEloquentStateMachines\StateMachines\StateMachine;

class BordereauStateMachine extends StateMachine
{
    public function recordHistory(): bool
    {
        return true;
    }

    public function transitions(): array
    {
        return [
            StatusBordereau::UNCASHED->value => StatusBordereau::CASHED->value,
        ];
    }

    public function defaultState(): ?string
    {
        return StatusBordereau::UNCASHED->value;
    }
}
