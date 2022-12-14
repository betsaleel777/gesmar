<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * ranger du plus récent au plus vieux
 */
trait RecentOrder
{
    protected static function booted()
    {
        static::addGlobalScope('recent', function (Builder $builder) {
            $builder->orderByDesc('created_at');
        });
    }
}

?>
