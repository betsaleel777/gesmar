<?php

namespace App\Models\Caisse;

use App\Models\Scopes\OwnSiteScope;
use App\Models\Scopes\RecentScope;
use App\Traits\HasOwnerScope;
use App\Traits\HasResponsible;
use App\Traits\HasSites;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @mixin IdeHelperBanque
 */
class Banque extends Model implements Auditable
{
    use HasSites;
    use HasResponsible;
    use \OwenIt\Auditing\Auditable;
    use HasOwnerScope;

    protected $fillable = ['sigle', 'nom', 'site_id'];

    const RULES = [
        'sigle' => 'required',
        'nom' => 'required|max:191',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new RecentScope);
        static::addGlobalScope(new OwnSiteScope);
    }
}
