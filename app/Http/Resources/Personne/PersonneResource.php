<?php

namespace App\Http\Resources\Personne;

use App\Http\Resources\SiteResource;
use App\Http\Resources\TypePersonneResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonneResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->whenNotNull($this->code),
            'nom' => $this->whenNotNull($this->nom),
            'prenom' => $this->whenNotNull($this->prenom),
            'adresse' => $this->whenNotNull($this->adresse),
            'ville' => $this->whenNotNull($this->ville),
            'contact' => $this->whenNotNull($this->contact),
            'site_id' => $this->whenNotNull($this->site_id),
            'created_at' => $this->whenNotNull($this->created_at),
            'status' => $this->whenAppended('status'),
            'complet' => $this->whenNotNull($this->getComplet()),
            'alias' => $this->whenNotNull($this->getAlias()),
            'fullname' => $this->whenNotNull($this->getFullname()),
            'email' => $this->whenNotNull($this->email),
            'type_personne_id' => $this->whenNotNull($this->type_personne_id),
            'numero_compte' => $this->whenNotNull($this->numero_compte),
            'banque' => $this->whenNotNull($this->banque),
            'lieu_naissance' => $this->whenNotNull($this->lieu_naissance),
            'profession' => $this->whenNotNull($this->profession),
            'naissance' => $this->whenNotNull($this->naissance),
            'nationalite' => $this->whenNotNull($this->nationalite),
            'profession_conjoint' => $this->whenNotNull($this->profession_conjoint),
            'naissance_conjoint' => $this->whenNotNull($this->naissance_conjoint),
            'nom_complet_conjoint' => $this->whenNotNull($this->nom_complet_conjoint),
            'regime' => $this->whenNotNull($this->regime),
            'date_mariage' => $this->whenNotNull($this->date_mariage),
            'lieu_mariage' => $this->whenNotNull($this->lieu_mariage),
            'nom_complet_mere' => $this->whenNotNull($this->nom_complet_mere),
            'nom_complet_pere' => $this->whenNotNull($this->nom_complet_pere),
            'situation_matrimoniale' => $this->whenNotNull($this->situation_matrimoniale),
            'photocopie_carte' => $this->whenLoaded(config('constants.COLLECTION_MEDIA_PHOTOCOPIE'), fn() => $this->photocopie->getUrl()),
            'photo_identite' => $this->whenLoaded(config('constants.COLLECTION_MEDIA_IDENTITE'), fn() => $this->identite->getUrl()),
            'numero_carte' => $this->whenNotNull($this->numero_carte),
            'type' => TypePersonneResource::make($this->whenLoaded('type')),
            'site' => SiteResource::make($this->whenLoaded('site')),
        ];
    }
}
