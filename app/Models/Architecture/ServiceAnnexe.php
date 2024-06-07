<?php

namespace App\Models\Architecture;

use App\Models\Exploitation\Contrat;
use App\Models\Scopes\OwnSiteScope;
use App\Models\Scopes\RecentScope;
use App\Traits\HasOwnerScope;
use App\Traits\HasResponsible;
use App\Traits\HasSites;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @mixin IdeHelperServiceAnnexe
 */
class ServiceAnnexe extends Model implements Auditable
{
    use SoftDeletes, HasSites, HasOwnerScope, HasResponsible;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['code', 'nom', 'site_id', 'description'];
    protected $auditExclude = ['code', 'site_id'];
    public const RULES = ['nom' => 'required|max:250', 'site_id' => 'required'];

    protected static function booted()
    {
        static::addGlobalScope(new RecentScope);
        static::addGlobalScope(new OwnSiteScope);
    }

    public function codeGenerate(): void
    {
        $rang = empty($this->orderBy('id', 'desc')->first()) ? 1 : $this->orderBy('id', 'desc')->first()->id + 1;
        $this->attributes['code'] = ANNEXE_CODE_PREFIXE . str_pad((string) $rang, 5, '0', STR_PAD_LEFT) . Carbon::now()->format('y');
    }

    public function scopeIsBusy(Builder $query): Builder
    {
        return $query->whereHas('contrats', fn (Builder $query): Builder => $query->validated());
    }

    public function scopeIsFree(Builder $query): Builder
    {
        return $query->whereHas('contrats', fn (Builder $query): Builder => $query->aborted(), '=')->orDoesntHave('contrats');
    }

    public function contrats(): HasMany
    {
        return $this->hasMany(Contrat::class, 'annexe_id');
    }
}
