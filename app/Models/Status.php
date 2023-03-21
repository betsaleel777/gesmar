<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @mixin IdeHelperStatus
 */
class Status extends \Spatie\ModelStatus\Status
{
    use HasFactory;
}
