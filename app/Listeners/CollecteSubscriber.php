<?php

namespace App\Listeners;

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
            $attribution->collecter();
        }
        // vérifier si toutes les attributions du bordereau sont encaissées en vue de changer le statut du bordereau
        $bordereau = Bordereau::find((int)$attribution->bordereau?->id);
        $bordereau->attributions()->uncashed()->exists() ?: $bordereau->setCollected();
    }

    public function updateDependenciesAfterDelete(CollecteRemoved $event): void
    {
        $attribution = Attribution::with('bordereau')->findOrFail($event->collecte->attribution_id);
        $attribution->pasCollecter();
        // vérifier si toutes les attributions du bordereau sont encaissées en vue de changer le statut du bordereau
        $bordereau = Bordereau::find((int)$attribution->bordereau?->id);
        $bordereau->attributions()->uncashed()->exists() ?: $bordereau->setCollected();
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @return array<class-name, string>
     */
    public function subscribe(): array
    {
        return [
            CollecteRegistred::class => 'updateDependenciesAfterCreate',
            CollecteRemoved::class => 'updateDependenciesAfterDelete',
        ];
    }
}
