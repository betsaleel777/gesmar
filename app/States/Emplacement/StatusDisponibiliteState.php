<?php

namespace App\States\Emplacement;

use App\Enums\StatusEmplacement;
use Asantibanez\LaravelEloquentStateMachines\StateMachines\StateMachine;

class StatusDisponibiliteState extends StateMachine
{
    public function recordHistory(): bool
    {
        return true;
    }

    /**
     *
     * @return array<string, string>
     */
    public function transitions(): array
    {
        return [
            StatusEmplacement::FREE->value => StatusEmplacement::BUSY->value,
            StatusEmplacement::BUSY->value  => StatusEmplacement::FREE->value
        ];
    }

    public function defaultState(): string
    {
        return StatusEmplacement::FREE->value;
    }
}
