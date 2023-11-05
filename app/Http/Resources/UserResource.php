<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property User resource
 */
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
            'name' => $this->whenNotNull($this->resource->name),
            'email' => $this->whenNotNull($this->resource->email),
            'connected' => $this->whenNotNull($this->resource->connected),
            'description' => $this->whenNotNull($this->resource->description),
            'adresse' => $this->whenNotNull($this->resource->adresse),
            'created_at' => $this->whenNotNull($this->resource->created_at?->format('d-m-Y')),
            'avatar' => $this->whenLoaded('avatar', fn() => $this->resource->avatar->getUrl()),
            'role' => $this->whenLoaded('roles', fn() => $this->resource->roles->first()),
            'permissions' => $this->whenLoaded('roles', fn() => $this->getPermissionsViaRoles()->pluck('name')),
            'sites' => SiteResource::collection($this->whenLoaded('sites')),
        ];
    }
}
