<?php

namespace App\Listeners;

use App\Events\ContratRegistred;
use App\Events\FactureStatusChange;
use App\Models\Architecture\Emplacement;
use App\Models\Exploitation\Contrat;
use App\Models\Exploitation\Personne;
use App\Models\Finance\Facture;

class ContratSubscriber
{

    private function createFactureAnnexe(ContratRegistred $event)
    {
        $facture = new Facture();
        $facture->contrat_id = $event->contrat->id;
        $facture->codeGenerate(ANNEXE_PREFIXE);
        $facture->annexe_id = $event->contrat->annexe_id;
        $facture->save();
    }

    private function createFactureInitiale(ContratRegistred $event)
    {
        $emplacement = Emplacement::with('type')->find($event->contrat->emplacement_id);
        $facture = new Facture();
        $facture->contrat_id = $event->contrat->id;
        $facture->codeGenerate(INITIALE_PREFIXE);
        $facture->caution = $emplacement->caution;
        $facture->avance = $event->avance;
        $facture->pas_porte = (int) $emplacement->pas_porte;
        if ((bool) $emplacement->type->auto_valid === true) {
            $facture->setValider();
            $event->contrat->acompte();
            $event->contrat->save();
            $personne = Personne::find($event->contrat->personne_id);
            $personne->client();
            $personne->save();
        }
        $facture->save();
    }

    public function updateFactureStatus(FactureStatusChange $event)
    {
        if ($event->status === Facture::SHEDULABLE) {
            $event->facture->planifier();
            $event->facture->save();
        }
    }

    public function createFacture(ContratRegistred $event)
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
