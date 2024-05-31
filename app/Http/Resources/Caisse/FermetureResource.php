<?php

namespace App\Http\Resources\Caisse;

use App\Models\Caisse\Fermeture;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

/**
 * @property Fermeture $resource
 */
class FermetureResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->whenNotNull($this->created_at?->format('d-m-Y')),
            'status' => $this->whenNotNull($this->status),
            'caissier' => $this->whenLoaded('ouverture', fn() => Str::lower($this->ouverture->caissier->user->name)),
            'initial' => $this->whenLoaded('ouverture', fn() => (int) $this->ouverture->montant),
            'total' => $this->total,
            'perte' => $this->perte,
            'encaissements' => $this->when(
                $this->relationLoaded('ouverture'),
                fn() => $this->ouverture->relationLoaded('encaissements') ?
                EncaissementResource::collection($this->ouverture->encaissements) : []
            ),
        ];
    }
}
