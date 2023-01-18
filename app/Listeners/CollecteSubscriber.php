<?php

namespace App\Listeners;

use App\Enums\StatusBordereau;
use App\Events\CollecteRegistred;
use App\Events\CollecteRemoved;
use App\Models\Finance\Attribution;
use App\Models\Finance\Bordereau;

class CollecteSubscriber
{
    public function updateDependenciesAfterCreate(CollecteRegistred $event): void
    {
        $attribution = Attribution::with('bordereau')->findOrFail($event->collecte->attribution_id);
        if ($event->collecte->nombre === 1) {
            $attribution->encaisser();
        }
        // vérifier si toutes les attributions du bordereau sont encaissées en vue de changer le statut du bordereau
        $bordereau = Bordereau::with('attributions')->findOrFail($attribution->bordereau?->id);
        $bordereau->attributions->contains('status', StatusBordereau::PAS_ENCAISSE->value) ?: $bordereau->encaisser();
    }

    public function updateDependenciesAfterDelete(CollecteRemoved $event): void
    {
        $attribution = Attribution::with('bordereau')->findOrFail($event->collecte->attribution_id);
        $attribution->pasEncaisser();
        // vérifier si toutes les attributions du bordereau sont encaissées en vue de changer le statut du bordereau
        $bordereau = Bordereau::with('attributions')->findOrFail($attribution->bordereau?->id);
        $bordereau->attributions->contains('status', StatusBordereau::PAS_ENCAISSE->value) ?: $bordereau->encaisser();
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events): array
    {
        return [
            CollecteRegistred::class => 'updateDependenciesAfterCreate',
            CollecteRemoved::class => 'updateDependenciesAfterDelete',
        ];
    }
}
