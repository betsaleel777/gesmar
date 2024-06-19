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
class FactureLoyerResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'status' => $this->whenAppended('status'),
            'periode' => $this->whenNotNull($this->resource->periode),
            'loyer' => $this->whenNotNull($this->resource->montant_loyer),
            'created_at' => $this->whenNotNull($this?->created_at),
            'contrat' => ContratResource::make($this->whenLoaded('contrat')),
            'audit' => AuditResource::make($this->whenLoaded('audit')),
            'personne' => PersonneResource::make($this->whenLoaded('personne')),
        ];
    }
}
