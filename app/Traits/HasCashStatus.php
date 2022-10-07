<?php
namespace App\Traits;

use App\Enums\StatusBordereau;

/**
 * pour les models qui ont les status d'encaissements
 */
trait HasCashStatus
{
    public function encaisser(): void
    {
        $this->setStatus(StatusBordereau::ENCAISSE->value);
    }

    public function pasEncaisser(): void
    {
        $this->setStatus(StatusBordereau::PAS_ENCAISSE->value);
    }

    public function cashed()
    {
        return $this->status === StatusBordereau::ENCAISSE->value;
    }

    public function uncashed()
    {
        return $this->status === StatusBordereau::PAS_ENCAISSE->value;
    }
}

?>
