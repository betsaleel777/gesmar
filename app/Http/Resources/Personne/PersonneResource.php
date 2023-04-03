<?php

namespace App\Http\Resources\Personne;

use App\Http\Resources\SiteResource;
use App\Http\Resources\TypePersonneResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonneResource extends JsonResource
{
    public static $wrap = 'personne';
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
            'prenom' => $this->prenom,
            'adresse' => $this->adresse,
            'ville' => $this->ville,
            'contact' => $this->contact,
            'site_id' => $this->site_id,
            'created_at' => $this->created_at,
            'status' => $this->whenAppended('status'),
            'complet' => $this->whenAppended('complet'),
            'alias' => $this->whenAppended('alias'),
            'email' => $this->when(empty($this->email), '', $this->email),
            'type_personne_id' => $this->when(empty($this->type_personne_id), ''),
            'numero_compte' => $this->when(empty($this->numero_compte), '', $this->numero_compte),
            'banque' => $this->when(empty($this->banque), '', $this->banque),
            'lieu_naissance' => $this->when(empty($this->lieu_naissance), '', $this->lieu_naissance),
            'profession' => $this->when(empty($this->profession), '', $this->profession),
            'naissance' => $this->when(empty($this->naissance), '', $this->naissance),
            'nationalite' => $this->when(empty($this->nationalite), '', $this->nationalite),
            'profession_conjoint' => $this->when(empty($this->profession_conjoint), '', $this->profession_conjoint),
            'naissance_conjoint' => $this->when(empty($this->naissance_conjoint), '', $this->naissance_conjoint),
            'nom_complet_conjoint' => $this->when(empty($this->nom_complet_conjoint), '', $this->nom_complet_conjoint),
            'regime' => $this->when(empty($this->regime), '', $this->regime),
            'date_mariage' => $this->when(empty($this->date_mariage), '', $this->date_mariage),
            'lieu_mariage' => $this->when(empty($this->lieu_mariage), '', $this->lieu_mariage),
            'nom_complet_mere' => $this->when(empty($this->nom_complet_mere), '', $this->nom_complet_mere),
            'nom_complet_pere' => $this->when(empty($this->nom_complet_pere), '', $this->nom_complet_pere),
            'situation_matrimoniale' => $this->when(empty($this->situation_matrimoniale), '', $this->situation_matrimoniale),
            'photocopie_carte' => $this->whenLoaded(COLLECTION_MEDIA_PHOTOCOPIE, fn () => $this->identite->getUrl()),
            'photo_identite' => $this->whenLoaded(COLLECTION_MEDIA_IDENTITE, fn () => $this->identite->getUrl()),
            'type' => TypePersonneResource::make($this->whenLoaded('type')),
            'site' => SiteResource::make($this->whenLoaded('site')),
        ];
    }
}
