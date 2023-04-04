<?php

namespace App\Http\Resources\Contrat;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DemandeAnnexeCollection extends ResourceCollection
{
    public static $wrap = "contrats";
    public $collects = DemandeAnnexeResource::class;
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): Arrayable
    {
        return $this->collection;
    }
}
