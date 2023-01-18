<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * pour les models qui utilisent une relation vers le un site
 */
trait HasSites
{
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
