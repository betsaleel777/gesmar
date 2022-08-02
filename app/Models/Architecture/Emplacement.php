<?php

namespace App\Models\Architecture;

use App\Models\Exploitation\Contrat;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperEmplacement
 */
class Emplacement extends Model
{
    use SoftDeletes;

    protected $fillable = ['nom', 'code', 'superficie', 'type_emplacement_id', 'zone_id', 'date_occupe', 'loyer', 'pas_porte', 'caution'];

    protected $appends = ['status'];

    const RULES = [
        'nom' => 'required|max:255',
        'superficie' => 'required',
        'loyer' => 'required',
        'zone_id' => 'required',
        'type_emplacement_id' => 'required',
    ];

    const PUSH_RULES = [
        'superficie' => 'required',
        'loyer' => 'required',
        'zone_id' => 'required',
        'type_emplacement_id' => 'required',
        'nombre' => 'required|numeric',
    ];

    private const OCCUPE = 'occupé';

    private const LIBRE = 'libre';

    /**
     * Undocumented function
     *
     * @return Attribute{get:(callable(): string)}
     */
    protected function code(): Attribute
    {
        return new Attribute(
            get:fn () => str_pad((string) $this->attributes['code'], 3, '0', STR_PAD_LEFT),
        );
    }

    /**
     * Undocumented function
     *
     * @return Attribute{get:(callable(): string)}
     */
    protected function status(): Attribute
    {
        return new Attribute(
            get:fn () => $this->attributes['date_occupe'] ? self::OCCUPE : self::LIBRE
        );
    }

    public function occuper(): void
    {
        $this->attributes['date_occupe'] = Carbon::now();
    }

    public function isBusy(): bool
    {
        return ! empty($this->attributes['date_occupe']);
    }

    public function liberer(): void
    {
        $this->attributes['date_occupe'] = null;
    }

    public function isFree(): bool
    {
        return empty($this->attributes['date_occupe']);
    }

    //scopes

    /**
     * Undocumented function
     *
     * @param  Builder<Emplacement>  $query
     * @return Builder<Emplacement>
     */
    public function scopeLibres(Builder $query): Builder
    {
        return $query->whereNull('date_occupe');
    }

    /**
     * Undocumented function
     *
     * @param  Builder<Emplacement>  $query
     * @return Builder<Emplacement>
     */
    public function scopeOccupes(Builder $query): Builder
    {
        return $query->whereNotNull('date_occupe');
    }

    //relations
    /**
     * Undocumented function
     *
     * @return BelongsTo<Zone>
     */
    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo<TypeEmplacement>
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(TypeEmplacement::class, 'type_emplacement_id');
    }

    /**
     * Undocumented function
     *
     * @return BelongsToMany<Equipement>
     */
    public function equipements(): BelongsToMany
    {
        return $this->belongsToMany(Equipement::class, 'abonnements')->wherePivotNull('date_resiliation')
            ->using(Abonnement::class)->withTimestamps();
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo<Contrat>
     */
    public function contrat(): BelongsTo
    {
        return $this->belongsTo(Contrat::class);
    }
}
