<?php

namespace App\Models\Caisse;

use App\Enums\StatusOuverture;
use App\Models\Scopes\RecentScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\ModelStatus\HasStatuses;

/**
 * @mixin IdeHelperOuverture
 */
class Ouverture extends Model
{
    use HasStatuses, \Staudenmeir\EloquentHasManyDeep\HasRelationships;
    protected $fillable = ['guichet_id', 'caissier_id', 'date', 'code', 'montant'];
    protected $dates = ['created_at'];
    protected $casts = ['date' => 'date'];
    protected $appends = ['status'];
    protected $with = ['guichet.site', 'caissier'];

    const RULES = [
        'guichet_id' => 'required|numeric',
        'caissier_id' => 'required|numeric',
        'date' => 'required|date',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new RecentScope);

        static::created(function (Ouverture $ouverture) {
            Guichet::find($ouverture->guichet_id)->setOpen();
        });
    }

    public function codeGenerate(): void
    {
        $rang = $this->count() + 1;
        $this->attributes['code'] = OUVERTURE_CODE_PREFIXE . str_pad((string) $rang, 7, '0', STR_PAD_LEFT);
    }

    public function setConfirmed(): void
    {
        $this->setStatus(StatusOuverture::CONFIRMED->value);
    }

    public function setUsing(): void
    {
        $this->setStatus(StatusOuverture::USING->value);
    }

    public function scopeConfirmed(Builder $query): Builder
    {
        return $query->currentStatus(StatusOuverture::CONFIRMED->value);
    }

    public function scopeUsing(Builder $query): Builder
    {
        return $query->currentStatus(StatusOuverture::USING->value);
    }

    public function caissier(): BelongsTo
    {
        return $this->belongsTo(Caissier::class,);
    }

    public function guichet(): BelongsTo
    {
        return $this->belongsTo(Guichet::class);
    }

    public function encaissements(): HasMany
    {
        return $this->hasMany(Encaissement::class);
    }
}
