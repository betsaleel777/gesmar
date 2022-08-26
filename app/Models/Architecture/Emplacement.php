<?php

namespace App\Models\Architecture;

use App\Enums\StatusAbonnement;
use App\Enums\StatusEmplacement;
use App\Models\Exploitation\Contrat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStatus\HasStatuses;

/**
 * @mixin IdeHelperEmplacement
 */
class Emplacement extends Model
{
    use SoftDeletes;
    use HasStatuses;

    protected $fillable = ['nom', 'code', 'superficie', 'type_emplacement_id', 'zone_id', 'loyer', 'pas_porte', 'caution'];

    protected $appends = ['statuts'];
    protected $with = ['statuses'];

    public const RULES = [
        'nom' => 'required|max:255',
        'superficie' => 'required',
        'loyer' => 'required',
        'zone_id' => 'required',
        'type_emplacement_id' => 'required',
    ];

    public const PUSH_RULES = [
        'superficie' => 'required',
        'loyer' => 'required',
        'zone_id' => 'required',
        'type_emplacement_id' => 'required',
        'nombre' => 'required|numeric',
    ];

    /**
     * Undocumented function
     *
     * @return Attribute<get:(callable():string)>
     */
    protected function code(): Attribute
    {
        return Attribute::make(
            get:fn () => str_pad((string) $this->attributes['code'], 3, '0', STR_PAD_LEFT),
        );
    }

    /**
     * Undocumented function
     *
     * @return Attribute<get:(callable():string)>
     */
    protected function statuts(): Attribute
    {
        return Attribute::make(
            get:function () {
                $status[] = $this->latestStatus(StatusEmplacement::BUSY->value, StatusEmplacement::FREE->value);
                $status[] = $this->latestStatus(StatusEmplacement::LINKED->value, StatusEmplacement::UNLINKED->value);
                return $status;
            }
        );
    }

    public function occuper(): void
    {
        $this->setStatus(StatusEmplacement::BUSY->value);
    }

    public function lier(): void
    {
        $this->setStatus(StatusEmplacement::LINKED->value);
    }

    public function delier(): void
    {
        $this->setStatus(StatusEmplacement::UNLINKED->value);
    }

    public function liberer(): void
    {
        $this->setStatus(StatusEmplacement::FREE->value);
    }


    //scopes

    /**
     * obtenir les emplacements occupés
     *
     * @param Builder<Emplacement> $query
     * @return Builder<Emplacement>
     */
    public function scopeIsBusy(Builder $query): Builder
    {
        return $query->whereHas('statuses', function ($query) {
            return $query->where('name', StatusEmplacement::BUSY->value) ;
        });
    }

    /**
     * obtenir les emplacements libres
     *
     * @param Builder<Emplacement> $query
     * @return Builder<Emplacement>
     */
    public function scopeIsFree(Builder $query): Builder
    {
        return $query->whereHas('statuses', function ($query) {
            return $query->where('name', StatusEmplacement::FREE->value) ;
        });
    }

    /**
     * obtenir les emplacements liés à au moins un equipement
     *
     * @param Builder<Emplacement> $query
     * @return Builder<Emplacement>
     */
    public function scopeIsLinked(Builder $query): Builder
    {
        return $query->whereHas('statuses', function ($query) {
            return $query->where('name', StatusEmplacement::LINKED->value) ;
        });
    }

    /**
     * obtenir les emplacements liés à aucun equipement
     *
     * @param Builder<Emplacement> $query
     * @return Builder<Emplacement>
     */
    public function scopeIsUnlinked(Builder $query): Builder
    {
        return $query->whereHas('statuses', function ($query) {
            return $query->where('name', StatusEmplacement::UNLINKED->value) ;
        });
    }

    //relations

    /**
     * Undocumented function
     *
     * @return BelongsTo<Zone, Emplacement>
     */
    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo<TypeEmplacement, Emplacement>
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
    public function abonnements(): BelongsToMany
    {
        return $this->belongsToMany(Equipement::class, 'abonnements')->whereHas('statuses', function ($query) {
            return $query->where('name', StatusAbonnement::PROGRESSING->value) ;
        })->using(Abonnement::class)->withTimestamps();
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo<Contrat, Emplacement>
     */
    public function contrat(): BelongsTo
    {
        return $this->belongsTo(Contrat::class);
    }

    /**
     * Undocumented function
     *
     * @return HasMany<Equipement, Emplacement>
     */
    public function equipements(): HasMany
    {
        return $this->hasMany(Equipement::class);
    }
}
