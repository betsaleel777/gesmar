<?php

namespace App\Listeners;

use App\Enums\StatusEmplacement;
use App\Enums\StatusEquipement;
use App\Events\AbonnementRegistred;
use App\Events\AbonnementResilied;
use App\Models\Architecture\Emplacement;
use App\Models\Architecture\Equipement;
use App\Models\Finance\Facture;

class AbonnementSubscriber
{
    public function updateDependenciesAfterDelete(AbonnementResilied $event): void
    {
        $equipement = Equipement::findOrFail($event->abonnement->equipement_id);
        $equipement->desabonner();
    }

    public function updateDependenciesAfterCreate(AbonnementRegistred $event): void
    {
        $event->abonnement->index_depart === $event->abonnement->index_autre ? $event->abonnement->waiting() : $event->abonnement->error();
        $equipement = Equipement::find($event->abonnement->equipement_id);
        if ($equipement->liaison !== StatusEquipement::LINKED->value) {
            $equipement->emplacement_id = $event->abonnement->emplacement_id;
            $equipement->save();
            $equipement->lier();
        }
        $emplacement = Emplacement::find($event->abonnement->emplacement_id);
        if ($emplacement->liaison !== StatusEmplacement::LINKED->value) {
            $emplacement->lier();
        }
        // créer une facture d'abonnement
        $facture = new Facture();
        $facture->abonnement_id = $event->abonnement->id;
        $facture->codeGenerate(config('constants.ABONNEMENT_FACTURE_PREFIXE'));
        $facture->caution_abonnement = $equipement->load('type')->type->caution_abonnement;
        $facture->contrat_id = $event->abonnement->contrat_id;
        $facture->save();
        /*$contrat = $event->abonnement->load('emplacement:id', 'emplacement.contratPending')->emplacement->contratPending;
        if ($contrat) {
            $contrat->equipements()->updateExistingPivot($equipement->type, ['abonnable' => false]);
        }*/
    }

    public function subscribe(): array
    {
        return [
            AbonnementResilied::class => 'updateDependenciesAfterDelete',
            AbonnementRegistred::class => 'updateDependenciesAfterCreate',
        ];
    }
}
