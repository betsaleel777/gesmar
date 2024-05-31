<?php

namespace App\Models\Caisse;

use App\Enums\StatusOuverture;
use App\Models\Architecture\Site;
use App\Models\Scopes\OwnSiteScope;
use App\Models\Scopes\RecentScope;
use App\Traits\HasOwnerScope;
use App\Traits\HasResponsible;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\ModelStatus\HasStatuses;

/**
 * @mixin IdeHelperOuverture
 */
class Ouverture extends Model implements Auditable
{
    use HasStatuses, \Staudenmeir\EloquentHasManyDeep\HasRelationships;
    use \OwenIt\Auditing\Auditable;
    use HasResponsible;
    use HasOwnerScope;

    protected $fillable = ['guichet_id', 'caissier_id', 'date', 'code', 'montant'];
    protected $auditExclude = ['code'];
    protected $dates = ['created_at'];
    protected $casts = ['date' => 'date'];
    protected $appends = ['status'];

    const RULES = [
        'guichet_id' => 'required|numeric',
        'caissier_id' => 'required|numeric',
        'date' => 'required|date',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new RecentScope);
        static::addGlobalScope(new OwnSiteScope);
    }

    public function codeGenerate(): void
    {
        $rang = empty($this->latest()->first()) ? 1 : $this->latest()->first()->id + 1;
        $this->attributes['code'] = OUVERTURE_CODE_PREFIXE . str_pad((string) $rang, 5, '0', STR_PAD_LEFT) . Carbon::now()->format('y');
    }

    public function setConfirmed(): void
    {
        $this->setStatus(StatusOuverture::CONFIRMED->value);
    }

    public function setChecking(): void
    {
        $this->setStatus(StatusOuverture::CHECKING->value);
    }

    public function setUsing(): void
    {
        $this->setStatus(StatusOuverture::USING->value);
    }

    public function scopeConfirmed(Builder $query): Builder
    {
        return $query->currentStatus(StatusOuverture::CONFIRMED->value);
    }

    public function scopeChecked(Builder $query): Builder
    {
        return $query->currentStatus(StatusOuverture::CHECKING->value);
    }

    public function scopeUsing(Builder $query): Builder
    {
        return $query->currentStatus(StatusOuverture::USING->value);
    }

    public function caissier(): BelongsTo
    {
        return $this->belongsTo(Caissier::class, );
    }

    public function guichet(): BelongsTo
    {
        return $this->belongsTo(Guichet::class);
    }

    public function encaissements(): HasMany
    {
        return $this->hasMany(Encaissement::class);
    }

    public function site(): HasOneThrough
    {
        return $this->hasOneThrough(Site::class, Guichet::class, 'id', 'id', 'guichet_id', 'site_id');
    }
}
