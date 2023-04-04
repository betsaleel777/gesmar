<?php

namespace App\Http\Resources\Contrat;

use Illuminate\Http\Resources\Json\JsonResource;

class EquipementResource extends JsonResource
{
    public static $wrap = "equipement";
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'frais_penalite' => $this->frais_penalite,
            'caution_abonnement' => $this->caution_abonnement,
            'created_at' => $this->created_at,
            'site_id' => $this->site_id,
            'periode' => $this->periode,
            'pivot' => $this->whenPivotLoaded('contrats_type_equipements', fn () => [
                'contrat_id' => $this->pivot->contrat_id,
                'type_equipement_id' => $this->pivot->type_equipement_id,
                'abonnable' => $this->pivot->abonnable,
            ]),
        ];
    }
}
