<?php

namespace App\Listeners;

use App\Events\TermeContratAnnexeRegistred;
use App\Events\TermeContratBailRegistred;
use App\Models\Template\TermesContratAnnexe;
use App\Models\Template\TermesContratEmplacement;
use Elibyy\TCPDF\Facades\TCPDF;

class TermeContratSubscriber
{
    private static function createPDF(string $filename, string $html): string
    {
        TCPDF::Reset();
        TCPDF::SetTitle('Example de Contrat');
        TCPDF::setCellHeightRatio(1.10);
        TCPDF::AddPage();
        TCPDF::writeHTML($html, true, false, true, false, '');
        $pathStorage = public_path() . '/storage' . '/' . $filename;
        TCPDF::Output($pathStorage, 'F');
        return $pathStorage;
    }

    public function afterGabariAnnexeRegistred(TermeContratBailRegistred $event): void
    {
        $oldTermeUsed = TermesContratAnnexe::where('id', '!=', $event->terme->id)->isUsed()->first();
        empty($oldTermeUsed) ?: $oldTermeUsed->notUsed();
        $path = self::createPDF('exampleContratAnnexe.pdf', $event->terme->contenu);
        $event->terme->addMedia($path)->toMediaCollection(COLLECTION_MEDIA_CONTRAT_ANNEXE);
    }


    public function afterGabariBailRegistred(TermeContratBailRegistred $event): void
    {
        $oldTermeUsed = TermesContratEmplacement::where('id', '!=', $event->terme->id)->isUsed()->first();
        empty($oldTermeUsed) ?: $oldTermeUsed->notUsed();
        $path = self::createPDF('exampleContratBail.pdf', $event->terme->contenu);
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
