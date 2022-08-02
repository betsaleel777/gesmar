<?php

namespace App\Models\Architecture;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @mixin IdeHelperAbonnement
 */
class Abonnement extends Pivot
{
    protected $fillable = ['code', 'equipement_id', 'emplacement_id', 'index_depart', 'index_fin', 'index_autre', 'date_resiliation', 'site_id'];

    protected $table = 'abonnements';

    /**
     * variables dynamiques
     *
     * @var array<int, string>
     */
    protected $appends = ['status'];

    const PROGRESSING = 'en cours';

    const STOPPED = 'résilié';

    const RULES = [
        'equipement_id' => 'required',
        'emplacement_id' => 'required',
        'index_depart' => 'required|numeric',
        'site_id' => 'required',
    ];

    const FINISH_RULES = [
        'index_fin' => 'required|numeric',
    ];

    /**
     * Undocumented function
     *
     * @return Attribute{get:(callable(): string)}
     */
    protected function status(): Attribute
    {
        return new Attribute(
            get:fn() => empty($this->attributes['date_resiliation']) ? self::PROGRESSING : self::STOPPED
        );
    }

    public function stop(): void
    {
        $this->attributes['date_resiliation'] = Carbon::now();
    }

    public function process(): void
    {
        $this->attributes['date_resiliation'] = null;
    }

    // scopes
    /**
     * Undocumented function
     *
     * @param  Builder<Abonnement>  $query
     * @return Builder<Abonnement>
     */
    public function scopeResilies(Builder $query): Builder
    {
        return $query->whereNotNull('date_resiliation');
    }

    /**
     * Undocumented function
     *
     * @param  Builder<Abonnement>  $query
     * @return Builder<Abonnement>
     */
    public function scopeEnCours(Builder $query): Builder
    {
        return $query->whereNull('date_resiliation');
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo<Equipement>
     */
    public function equipement(): BelongsTo
    {
        return $this->belongsTo(Equipement::class);
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo<Emplacement>
     */
    public function emplacement(): BelongsTo
    {
        return $this->belongsTo(Emplacement::class);
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo<Site>
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
