<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperStatus
 */
class Status extends \Spatie\ModelStatus\Status
{
    use HasFactory;
}
