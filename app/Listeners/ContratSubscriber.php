<?php

namespace App\Listeners;

use App\Events\ContratAnnexeAcompted;
use App\Events\ContratAnnexeRegistred;
use App\Events\ContratBailAcompted;
use App\Events\ContratBailRegistred;
use App\Models\Architecture\Emplacement;
use App\Models\Exploitation\Personne;
use App\Models\Finance\Facture\Facture;

class ContratSubscriber
{

    public function createFactureAnnexe(ContratAnnexeRegistred $event)
    {
        $facture = new Facture();
        $facture->contrat_id = $event->contrat->id;
        $facture->codeGenerate(ANNEXE_PREFIXE);
        $facture->annexe_id = $event->contrat->annexe_id;
        $facture->save();
    }

    public function createFactureInitiale(ContratBailRegistred $event)
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

    public function firstPaiementDone(ContratBailAcompted $event)
    {
        $event->contrat->accompte();
        $event->contrat->save();
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
            ContratAnnexeRegistred::class,
            [ContratSubscriber::class, 'createFactureAnnexe']
        );
        $events->listen(
            ContratBailRegistred::class,
            [ContratSubscriber::class, 'createFactureInitiale']
        );
        $events->listen(
            ContratAnnexeAcompted::class,
            [ContratSubscriber::class, 'firstPaiementDone']
        );
    }
}
