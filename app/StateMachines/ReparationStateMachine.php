<?php

namespace App\StateMachines;

use App\Enums\StatusReparation;
use Asantibanez\LaravelEloquentStateMachines\StateMachines\StateMachine;

class ReparationStateMachine extends StateMachine
{
    public function recordHistory(): bool
    {
        return true;
    }

    public function transitions(): array
    {
        return [
            '*' => '*',
        ];
    }

    public function defaultState(): ?string
    {
        return StatusReparation::PENDING->value;
    }
}
