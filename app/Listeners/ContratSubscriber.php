<?php

namespace App\Listeners;

use App\Events\ContratRegistred;
use App\Events\FactureStatusChange;
use App\Models\Architecture\Emplacement;
use App\Models\Exploitation\Personne;
use App\Models\Finance\Facture;

class ContratSubscriber
{
    private function createFactureAnnexe(ContratRegistred $event): void
    {
        $facture = new Facture();
        $facture->contrat_id = $event->contrat->id;
        $facture->codeGenerate(ANNEXE_PREFIXE);
        $facture->annexe_id = $event->contrat->annexe_id;
        $facture->save();
    }

    private function createFactureInitiale(ContratRegistred $event): void
    {
        $emplacement = Emplacement::with('type')->findOrFail($event->contrat->emplacement_id);
        $facture = new Facture();
        $facture->contrat_id = $event->contrat->id;
        $facture->codeGenerate(INITIALE_PREFIXE);
        $facture->caution = $emplacement->caution;
        $facture->avance = $event->avance;
        $facture->pas_porte = (int) $emplacement->pas_porte;
        if ((bool) $emplacement->type->auto_valid === true) {
            $facture->planifier();
            $event->contrat->valider();
            $event->contrat->save();
            $personne = Personne::findOrFail($event->contrat->personne_id);
            $personne->client();
            $personne->save();
            $emplacement->occuper();
            $emplacement->save();
        }
        $facture->save();
    }

    public function updateFactureStatus(FactureStatusChange $event): void
    {
        if ($event->status === Facture::SHEDULABLE) {
            $event->facture->planifier();
            $event->facture->save();
        }
    }

    public function createFacture(ContratRegistred $event): void
    {
        $event->contrat->isAnnexe() ? $this->createFactureAnnexe($event) : $this->createFactureInitiale($event);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return void
     */
    public function subscribe($events)
    {
        $events->listen(
            ContratRegistred::class,
            [ContratSubscriber::class, 'createFacture']
        );
        $events->listen(
            FactureStatusChange::class,
            [ContratSubscriber::class, 'updateFactureStatus']
        );
    }
}
