<?php

namespace App\Listeners;

use App\Enums\StatusTermeContrat;
use App\Events\TermeContratAnnexeRegistred;
use App\Events\TermeContratBailRegistred;
use App\Models\Template\TermesContratAnnexe;
use App\Models\Template\TermesContratEmplacement;

class TermeContratSubscriber
{
    public function afterGabariAnnexeRegistred(TermeContratBailRegistred $event): void
    {
        TermesContratAnnexe::where('id', '!=', $event->terme->id)->get()->map->notUsed();
        $path = createPDF('exampleContratAnnexe.pdf', $event->terme->contenu);
        $event->terme->addMedia($path)->toMediaCollection(COLLECTION_MEDIA_CONTRAT_ANNEXE);
    }


    public function afterGabariBailRegistred(TermeContratBailRegistred $event): void
    {
        $termes = TermesContratEmplacement::where('id', '!=', $event->terme->id)->get();
        foreach ($termes as $terme) {
            $terme->status = StatusTermeContrat::NOTUSING->value;
            $terme->save();
        }
        $path = createPDF('exampleContratBail.pdf', $event->terme->contenu);
        $event->terme->addMedia($path)->toMediaCollection(COLLECTION_MEDIA_CONTRAT_BAIL);
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
