<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

/**
 * @mixin IdeHelperPermission
 */
class Permission extends SpatiePermission
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->mergeFillable(['description']);
    }
}
