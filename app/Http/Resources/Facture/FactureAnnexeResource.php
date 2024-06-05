<?php

namespace App\Http\Resources\Facture;

use App\Http\Resources\AuditResource;
use App\Http\Resources\Contrat\ContratResource;
use App\Http\Resources\Ordonnancement\PaiementResource;
use App\Http\Resources\Personne\PersonneResource;
use App\Http\Resources\ServiceAnnexeResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Finance\Facture;

/**
 * @property Facture $resource
 */
class FactureAnnexeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'montant' => $this->whenNotNull($this->montant_annexe),
            'contrat' => ContratResource::make($this->whenLoaded('contrat')),
            'personne' => PersonneResource::make($this->whenLoaded('personne')),
            'annexe' => ServiceAnnexeResource::make($this->whenLoaded('annexe')),
            'audit' => AuditResource::make($this->whenLoaded('audit')),
        ];
    }
}
