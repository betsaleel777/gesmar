<?php

namespace App\Models\Caisse;

use App\Enums\StatusFermeture;
use App\Models\Architecture\Site;
use App\Models\Exploitation\Ordonnancement;
use App\Models\Scopes\OwnSiteScope;
use App\Models\Scopes\RecentScope;
use App\Traits\HasOwnerScope;
use App\Traits\HasResponsible;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as ContractAuditable;
use Spatie\ModelStatus\HasStatuses;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasOneDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

/**
 * @mixin IdeHelperFermeture
 */
class Fermeture extends Model implements ContractAuditable
{
    use Auditable, HasRelationships, HasResponsible, HasOwnerScope, HasStatuses;

    protected $fillable = ['code', 'ouverture_id', 'total', 'perte'];
    protected $casts = ['total' => 'integer', 'perte' => 'integer'];
    protected $dates = ['created_at'];

    const RULES = ['caissier_id' => 'required', 'total' => 'required'];

    protected static function booted(): void
    {
        static::addGlobalScope(new RecentScope);
        static::addGlobalScope(new OwnSiteScope);
    }

    public function setPending(): void
    {
        $this->setStatus(StatusFermeture::PENDING->value);
    }

    public function setWithLoss(string $reason): void
    {
        $this->setStatus(StatusFermeture::WITHLOSS->value, $reason);
    }

    public function setWithoutLoss(): void
    {
        $this->setStatus(StatusFermeture::WITHOUTLOSS->value);
    }

    public function codeGenerate(): void
    {
        $rang = empty($this->latest()->first()) ? 1 : $this->latest()->first()->id + 1;
        $this->attributes['code'] = FERMETURE_CODE_PREFIXE . str_pad((string) $rang, 5, '0', STR_PAD_LEFT) . Carbon::now()->format('y');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->currentStatus(StatusFermeture::PENDING->value);
    }

    public function scopeWithloss(Builder $query): Builder
    {
        return $query->currentStatus(StatusFermeture::WITHLOSS->value);
    }

    public function scopeWithoutloss(Builder $query): Builder
    {
        return $query->currentStatus(StatusFermeture::WITHOUTLOSS->value);
    }

    public function ouverture(): BelongsTo
    {
        return $this->belongsTo(Ouverture::class);
    }

    public function ordonnancement(): HasManyDeep
    {
        return $this->hasManyDeep(
            Ordonnancement::class,
            [Ouverture::class, Encaissement::class],
            ['id', 'ouverture_id', 'id'],
            ['ouverture_id', 'id', 'ordonnancement_id']
        );
    }

    public function site(): HasOneDeep
    {
        return $this->hasOneDeep(
            Site::class,
            [Ouverture::class, Guichet::class],
            ['id', 'id', 'id'],
            ['ouverture_id', 'guichet_id', 'site_id'],
        );
    }

    public function guichet(): HasOneThrough
    {
        return $this->hasOneThrough(Guichet::class, Ouverture::class, 'id', 'id', 'ouverture_id', 'guichet_id');
    }

    public function caissier(): HasOneThrough
    {
        return $this->hasOneThrough(Caissier::class, Ouverture::class, 'id', 'id', 'ouverture_id', 'caissier_id');
    }
}
