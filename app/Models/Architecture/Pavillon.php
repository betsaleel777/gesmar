<?php

namespace App\Models\Architecture;

use App\Models\Scopes\OwnSiteScope;
use App\Models\Scopes\RecentScope;
use App\Traits\HasSites;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @mixin IdeHelperPavillon
 */
class Pavillon extends Model implements Auditable
{
    use SoftDeletes, HasSites;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['nom', 'code', 'site_id'];
    protected $dates = ['created_at'];
    /**
     *
     * @var array<int, string>
     */
    const RULES = [
        'nom' => 'required|max:150',
        'site_id' => 'required',
    ];

    const MIDDLE_RULES = [
        'site_id' => 'required',
        'nombre' => 'required|numeric|min:1',
    ];

    const PUSH_RULES = [
        'nombre' => 'required|numeric|min:1',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::addGlobalScope(new RecentScope);
        static::addGlobalScope(new OwnSiteScope);
    }

    public function getCode(): ?string
    {
        return !empty($this->code) ? str((string) $this->attributes['code'])->padLeft(2, '0') : null;
    }
    /**
     * Obtenir les pavillons appartenant à la liste de site accéssible à l'utilisateur courant
     *
     */
    public function scopeInside(Builder $query, array $sites): Builder
    {
        return $query->whereHas('sites', fn($query) => $query->whereIn('sites.id', $sites));
    }

    public function niveaux(): HasMany
    {
        return $this->hasMany(Niveau::class);
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
