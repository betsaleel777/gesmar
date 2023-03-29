<?php

namespace App\States\Terme;

use App\Enums\StatusTermeContrat;
use Asantibanez\LaravelEloquentStateMachines\StateMachines\StateMachine;

class StatusTermeStateMachine extends StateMachine
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
            '*' => '*'
        ];
    }

    public function defaultState(): string
    {
        return StatusTermeContrat::USING->value;
    }
}
