<?php

namespace App\Listeners;

use App\Events\EquipementRegistred;
use App\Events\EquipementRemoved;
use App\Models\Architecture\Emplacement;
use App\Models\Finance\Facture;
use Illuminate\Events\Dispatcher;

class EquipementSubscriber
{
    public function updateDependenciesAfterCreate(EquipementRegistred $event): void
    {
        // delier l'ancien emplacement
        if (!empty($event->ancienEmplacement)) {
            $emplacement = Emplacement::findOrFail($event->ancienEmplacement);
            $emplacement->delier();
        }
        // lier le nouveau emplacement et aussi l'equipement en question
        if (!empty($event->equipement->emplacement_id)) {
            $event->equipement->lier();
            $emplacement = Emplacement::findOrFail($event->equipement->emplacement_id);
            $emplacement->lier();
        }
    }

    public function updateDependenciesAfterDelete(EquipementRemoved $event): void
    {
        Emplacement::findOrFail($event->equipement->emplacement_id)->delier();
        Facture::whereHas('equipement', fn ($query) => $query->where('equipement_id', $event->equipement->id))->get()->all()->map->delete();
    }

    /**
     * Register the listeners for the subscriber.
     *@return array<class-name, string>
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(
            EquipementRegistred::class,
            [EquipementSubscriber::class, 'updateDependenciesAfterCreate'],
            EquipementRemoved::class,
            [EquipementSubscriber::class, 'updateDependenciesAfterDelete']
        );
    }
}
