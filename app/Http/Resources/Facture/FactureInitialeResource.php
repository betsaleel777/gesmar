<?php

namespace App\Http\Resources\Facture;

use App\Http\Resources\AuditResource;
use App\Http\Resources\Contrat\ContratResource;
use App\Http\Resources\Personne\PersonneResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Finance\Facture;

/**
 * @property Facture $resource
 */
class FactureInitialeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->whenNotNull($this->code),
            'avance' => $this->whenNotNull($this->avance),
            'caution' => $this->whenNotNull($this->caution),
            'status' => $this->whenNotNull($this->status),
            'pas_porte' => $this->whenNotNull($this->pas_porte),
            'frais_dossier' => $this->whenNotNull($this->frais_dossier),
            'frais_amenagement' => $this->whenNotNull($this->frais_amenagement),
            'created_at' => $this->whenNotNull($this?->created_at),
            'total' => $this->whenNotNull($this->resource->getFactureInitialeTotalAmount()),
            'sommeVersee' => (int)$this->sommeVersee ?? 0,
            'contrat' => ContratResource::make($this->whenLoaded('contrat')),
            'personne' => PersonneResource::make($this->whenLoaded('personne')),
            'audit' => AuditResource::make($this->whenLoaded('audit')),
        ];
    }
}
