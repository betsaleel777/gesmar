<?php

namespace App\Models\Caisse;

use App\Enums\StatusGuichet;
use App\Models\Scopes\OwnSiteScope;
use App\Models\Scopes\RecentScope;
use App\Traits\HasSites;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\ModelStatus\HasStatuses;

/**
 * @mixin IdeHelperGuichet
 */
class Guichet extends Model implements Auditable
{
    use HasStatuses, HasSites, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['nom', 'code', 'site_id'];
    protected $dates = ['created_at'];
    protected $auditExclude = ['code', 'site_id'];
    /**
     *
     * @var array<int, string>
     */
    protected $appends = ['status'];

    const RULES = [
        'nom' => 'required|max:255',
        'site_id' => 'required|numeric',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new RecentScope);
        static::addGlobalScope(new OwnSiteScope);
    }

    public function codeGenerate(): void
    {
        $rang = $this->count() + 1;
        $this->attributes['code'] = GUICHET_CODE_PREFIXE . str_pad((string) $rang, 7, '0', STR_PAD_LEFT);
    }

    public function setClose(): void
    {
        $this->setStatus(StatusGuichet::CLOSE->value);
    }

    public function setOpen(): void
    {
        $this->setStatus(StatusGuichet::OPEN->value);
    }

    // scopes

    /**
     * Obtenir les guichets fermés
     *
     * @param Builder<Guichet> $query
     * @return Builder<Guichet>
     */
    public function scopeClosed(Builder $query): Builder
    {
        return $query->currentStatus(StatusGuichet::CLOSE->value);
    }

    /**
     * Obtenir les guichets ouverts
     *
     * @param Builder<Guichet> $query
     * @return Builder<Guichet>
     */
    public function scopeOpened(Builder $query): Builder
    {
        return $query->currentStatus(StatusGuichet::OPEN->value);
    }
}
