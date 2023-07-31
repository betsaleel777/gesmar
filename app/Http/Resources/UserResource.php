<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'connected' => $this->connected,
            'description' => $this->description,
            'adresse' => $this->adresse,
            'created_at' => $this->created_at->format('d-m-Y'),
            'avatar' => $this->whenLoaded('avatar', fn () => $this->avatar->getUrl()),
            'role' => $this->whenLoaded('roles', fn () => $this->roles->first()),
            'permissions' => $this->whenLoaded('roles', fn () => $this->getPermissionsViaRoles()->pluck('name')),
            'sites' => $this->whenLoaded('sites', fn () => SiteResource::collection($this->sites)),
        ];
    }
}
