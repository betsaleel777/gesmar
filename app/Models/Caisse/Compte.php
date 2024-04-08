<?php

namespace App\Models\Caisse;

use App\Models\Scopes\OwnSiteScope;
use App\Models\Scopes\RecentScope;
use App\Traits\HasOwnerScope;
use App\Traits\HasResponsible;
use App\Traits\HasSites;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @mixin IdeHelperCompte
 */
class Compte extends Model implements Auditable
{
    use HasFactory, HasSites, HasOwnerScope, HasResponsible;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['code', 'nom', 'site_id'];
    protected $dates = ['created_at'];
    protected $auditExclude = ['site_id', 'code'];

    const RULES = [
        'code' => 'required',
        'nom' => 'required|max:191',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new RecentScope);
        static::addGlobalScope(new OwnSiteScope);
    }
}
