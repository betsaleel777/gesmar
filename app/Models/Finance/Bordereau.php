<?php

namespace App\Models\Finance;

use App\Enums\StatusBordereau;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\ModelStatus\HasStatuses;

class Bordereau extends Model
{
    use HasStatuses;
    protected $fillable = ['code', 'commercial_id', 'date_attribution'];

    /**
     *
     * @var array<int, string>
     */
    protected $appends = ['status'];

    const RULES = [
        'commercial_id' => 'required',
        'date_attribution' => 'required',
    ];

    public function codeGenerate(): void
    {
        $rang = $this->count() + 1;
        $this->attributes['code'] = BORDEREAU_CODE_PREFIXE . str_pad((string)$rang, 7, '0', STR_PAD_LEFT);
    }

    public function encaisser(): void
    {
        $this->setStatus(StatusBordereau::ENCAISSE->value);
    }

    public function pasEncaisser(): void
    {
        $this->setStatus(StatusBordereau::PAS_ENCAISSE->value);
    }

    /**
     *
     * @param  Builder<Bordereau>  $query
     * @return Builder<Bordereau>
     */
    public function scopeCashed(Builder $query): Builder
    {
        return $query->currentStatus(StatusBordereau::ENCAISSE->value);
    }

    /**
     *
     * @param  Builder<Bordereau>  $query
     * @return Builder<Bordereau>
     */
    public function scopeNotCashed(Builder $query): Builder
    {
        return $query->currentStatus(StatusBordereau::PAS_ENCAISSE->value);
    }

    /**
     * Obtenir les attributions d'un bordereau
     *
     * @return HasMany<Attribution>
     */
    public function attributions(): HasMany
    {
        return $this->hasMany(Attribution::class , 'jour', 'date_attribution');
    }

    /**
     * Obtenir le commercial d'un bordereau
     *
     * @return BelongsTo<Commercial, Bordereau>
     */
    public function commercial(): BelongsTo
    {
        return $this->belongsTo(Commercial::class);
    }
}
