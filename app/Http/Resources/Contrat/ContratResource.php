<?php

namespace App\Http\Resources\Contrat;

use App\Http\Resources\Emplacement\EmplacementResource;
use App\Http\Resources\Personne\PersonneResource;
use App\Http\Resources\ServiceAnnexeResource;
use App\Http\Resources\SiteResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ContratResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'debut' => $this->debut,
            'fin' => $this->fin,
            'site_id' => $this->site_id,
            'emplacement_id' => $this->emplacement_id,
            'personne_id' => $this->personne_id,
            'annexe_id' => $this->annexe_id,
            'created_at' => $this->created_at,
            'avance' => $this->avance,
            'equipable' => $this->equipable,
            'auto_valid' => $this->auto_valid,
            'type' => $this->type,
            'status' => $this->whenAppended('status'),
            'site' => SiteResource::make($this->whenLoaded('site')),
            'personne' => PersonneResource::make($this->whenLoaded('personne')),
            'annexe' => ServiceAnnexeResource::make($this->whenLoaded('annexe')),
            'emplacement' => EmplacementResource::make($this->whenLoaded('emplacement')),
            'equipements' => EquipementResource::collection($this->whenLoaded('equipements')),
        ];
    }
}
