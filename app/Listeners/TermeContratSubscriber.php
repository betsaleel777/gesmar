<?php

namespace App\Listeners;

use App\Events\TermeContratAnnexeRegistred;
use App\Events\TermeContratBailRegistred;
use App\Models\Template\TermesContratAnnexe;
use App\Models\Template\TermesContratEmplacement;

class TermeContratSubscriber
{
    public function afterGabariAnnexeRegistred(TermeContratBailRegistred $event): void
    {
        $oldTermeUsed = TermesContratAnnexe::where('id', '!=', $event->terme->id)->isUsed()->first();
        empty($oldTermeUsed) ?: $oldTermeUsed->notUsed();
        $path = createPDF('exampleContratAnnexe.pdf', $event->terme->contenu);
        $event->terme->addMedia($path)->toMediaCollection(COLLECTION_MEDIA_CONTRAT_ANNEXE);
    }


    public function afterGabariBailRegistred(TermeContratBailRegistred $event): void
    {
        $oldTermeUsed = TermesContratEmplacement::where('id', '!=', $event->terme->id)->isUsed()->first();
        empty($oldTermeUsed) ?: $oldTermeUsed->notUsed();
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
