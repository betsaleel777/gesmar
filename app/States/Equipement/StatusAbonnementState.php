<?php

namespace App\States\Equipement;

use App\Enums\StatusEquipement;
use Asantibanez\LaravelEloquentStateMachines\StateMachines\StateMachine;

class StatusAbonnementState extends StateMachine
{
    public function recordHistory(): bool
    {
        return true;
    }

    public function transitions(): array
    {
        return [
            StatusEquipement::UNSUBSCRIBED->value => StatusEquipement::SUBSCRIBED->value,
            StatusEquipement::SUBSCRIBED->value  => StatusEquipement::UNSUBSCRIBED->value
        ];
    }

    public function defaultState(): string
    {
        return StatusEquipement::UNSUBSCRIBED->value;
    }
}
