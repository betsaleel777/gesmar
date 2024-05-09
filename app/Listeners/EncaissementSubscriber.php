<?php

namespace App\Listeners;

use App\Enums\StatusContrat;
use App\Enums\StatusPersonne;
use App\Events\EncaissementRegistred;
use App\Events\FermetureRegistred;
use App\Events\OuvertureRegistred;
use App\Models\Bordereau\Bordereau;
use App\Models\Caisse\Encaissement;
use App\Models\Caisse\Guichet;
use App\Models\Caisse\Ouverture;
use App\Models\Exploitation\Contrat;
use App\Models\Exploitation\Ordonnancement;
use App\Services\FactureService;

class EncaissementSubscriber
{
    public function updateDependenciesAfterCreate(EncaissementRegistred $event): void
    {
        $event->encaissement->setOpen();
        empty($event->encaissement->bordereau_id) ? $this->updateOrdonnancementDependencies($event) :
        $this->updateBordereauDependencies($event);
    }

    private function updateBordereauDependencies(EncaissementRegistred $event): void
    {
        $bordereau = Bordereau::find($event->encaissement->bordereau_id);
        $bordereau->setCashed();
    }

    private function updateOrdonnancementDependencies(EncaissementRegistred $event): void
    {
        $ordonnancement = Ordonnancement::with('paiements.facture')->find($event->encaissement->ordonnancement_id);
        $ordonnancement->payer();
        /** @var Contrat $contrat */
        $contrat = Contrat::with('personne', 'emplacement')->findOrFail($ordonnancement->paiements->first()->facture->contrat_id);
        $contrat->codeContratGenerate();
        $contrat->save();
        $contrat->status === StatusContrat::VALIDATED->value ?: $contrat->validate();
        $contrat->personne->status === StatusPersonne::CLIENT->name ?: $contrat->personne->client();
        if ($contrat->emplacement) {
            $contrat->emplacement->occuper();
        }
        $service = new FactureService($ordonnancement->paiements);
        $service->checkPaid();
        $autresContratsEnAttente = Contrat::where('emplacement_id', $contrat->emplacement_id)->inProcess()->get();
        $autresContratsEnAttente->map->delete();
    }

    public function afterRegistredOuverture(OuvertureRegistred $event): void
    {
        Guichet::find($event->ouverture->id)->setOpen();
    }

    public function afterRegistredFermeture(FermetureRegistred $event): void
    {
        $ouverture = Ouverture::with('encaissements')->find($event->fermeture->ouverture_id);
        $ouverture->setConfirmed();
        $ouverture->encaissements->each(fn(Encaissement $encaissement) => $encaissement->setClose());
        Guichet::find($ouverture->guichet_id)->setClose();
    }

    public function subscribe(): array
    {
        return [
            EncaissementRegistred::class => 'updateDependenciesAfterCreate',
            OuvertureRegistred::class => 'afterRegistredOuverture',
            FermetureRegistred::class => 'afterRegistredFermeture',
        ];
    }
}
