<?php

namespace App\States\Emplacement;

use App\Enums\StatusEmplacement;
use Asantibanez\LaravelEloquentStateMachines\StateMachines\StateMachine;

class StatusLiaisonsState extends StateMachine
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
            StatusEmplacement::UNLINKED->value => StatusEmplacement::LINKED->value,
            StatusEmplacement::LINKED->value  => StatusEmplacement::UNLINKED->value
        ];
    }

    public function defaultState(): string
    {
        return StatusEmplacement::UNLINKED->value;
    }
}
