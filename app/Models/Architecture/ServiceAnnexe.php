<?php

namespace App\Models\Architecture;

use App\Enums\ModeServiceAnnexe;
use App\Models\Scopes\OwnSiteScope;
use App\Models\Scopes\RecentScope;
use App\Traits\HasContrats;
use App\Traits\HasSites;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @mixin IdeHelperServiceAnnexe
 */
class ServiceAnnexe extends Model implements Auditable
{
    use SoftDeletes, HasSites, HasContrats;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['code', 'nom', 'site_id', 'prix', 'description', 'mode'];
    protected $auditExclude = ['code', 'site_id'];
    public const RULES = [
        'nom' => 'required|max:250',
        'prix' => 'required',
        'site_id' => 'required',
        'mode' => 'required',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::addGlobalScope(new RecentScope);
        static::addGlobalScope(new OwnSiteScope);
    }

    public function codeGenerate(): void
    {
        $rang = $this->count() + 1;
        $this->attributes['code'] = ANNEXE_CODE_PREFIXE . str_pad((string) $rang, 7, '0', STR_PAD_LEFT);
    }

    public function forfaitaire(): void
    {
        $this->attributes['mode'] = ModeServiceAnnexe::FORFAIT;
    }

    public function quotidien(): void
    {
        $this->attributes['mode'] = ModeServiceAnnexe::QUOTIDIEN;
    }

    public function mensuel(): void
    {
        $this->attributes['mode'] = ModeServiceAnnexe::MENSUEL;
    }

    /**
     * Obtenir les services annexes appartenant à la liste de site accéssible
     *
     */
    public function scopeInside(Builder $query, array $sites): Builder
    {
        return $query->whereIn('site_id', $sites);
    }
}
