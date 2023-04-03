<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TypePersonneCollection extends ResourceCollection
{
    public static $wrap = 'types';
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
