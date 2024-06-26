<?php

namespace App\Http\Resources\Facture;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Finance\Facture;

/**
 * @property Facture $resource
 */
class FactureInitialeListResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->whenNotNull($this->code),
            'status' => $this->whenAppended('status'),
            'avance' => $this->whenNotNull($this->avance, 0),
            'caution' => $this->whenNotNull($this->caution, 0),
            'pas_porte' => $this->whenNotNull($this->pas_porte),
            'frais_dossier' => $this->whenNotNull($this->frais_dossier),
            'unmodifiable' => $this->whenNotNull($this->unmodifiable),
            'frais_amenagement' => $this->whenNotNull($this->frais_amenagement),
            'contrat' => $this->whenLoaded('contrat', fn () => $this->contrat->codification()),
            'personne' => $this->when(
                $this->relationLoaded('contrat') and $this->contrat->relationLoaded('personne'),
                $this->contrat->personne->nom . ' ' . $this->contrat->personne->prenom
            ),
            'emplacement' => $this->when(
                $this->relationLoaded('contrat') and $this->contrat->relationLoaded('emplacement'),
                fn () => $this->contrat->emplacement->code
            ),
        ];
    }
}
