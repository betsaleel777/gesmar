<?php

namespace App\States\Equipement;

use App\Enums\StatusEquipement;
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
            StatusEquipement::UNLINKED->value => StatusEquipement::LINKED->value,
            StatusEquipement::LINKED->value  => StatusEquipement::UNLINKED->value
        ];
    }

    public function defaultState(): string
    {
        return StatusEquipement::UNLINKED->value;
    }
}
