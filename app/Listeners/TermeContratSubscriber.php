<?php

namespace App\Listeners;

use App\Enums\StatusTermeContrat;
use App\Events\TermeContratAnnexeRegistred;
use App\Events\TermeContratBailRegistred;
use App\Models\Template\TermesContratAnnexe;
use App\Models\Template\TermesContratEmplacement;

class TermeContratSubscriber
{
    public function afterGabariAnnexeRegistred(TermeContratAnnexeRegistred $event): void
    {
        $path = createPDF('exampleContratAnnexe.pdf', $event->terme->contenu);
        $event->terme->addMedia($path)->toMediaCollection(config('constants.COLLECTION_MEDIA_CONTRAT_ANNEXE'));
    }


    public function afterGabariBailRegistred(TermeContratBailRegistred $event): void
    {
        $path = createPDF('exampleContratBail.pdf', $event->terme->contenu);
        $event->terme->addMedia($path)->toMediaCollection(config('constants.COLLECTION_MEDIA_CONTRAT_BAIL'));
    }

    public function beforeGabariAnnexeRegistred(): void
    {
        $termes = TermesContratEmplacement::select('id', 'status')->get();
        foreach ($termes as $terme) {
            $terme->status = StatusTermeContrat::NOTUSING->value;
            $terme->save();
        }
    }

    public function beforeGabariBailRegistred(): void
    {
        $termes = TermesContratAnnexe::select('id', 'status')->get();
        foreach ($termes as $terme) {
            $terme->status = StatusTermeContrat::NOTUSING->value;
            $terme->save();
        }
    }

    /**
     * Register the listeners for the subscriber.
     *@return array<class-name, string>
     */
    public function subscribe(): array
    {
        return [
            TermeContratAnnexeRegistred::class => 'afterGabariAnnexeRegistred',
            TermeContratBailRegistred::class => 'afterGabariBailRegistred',
        ];
    }
}
