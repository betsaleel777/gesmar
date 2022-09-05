<?php

namespace App\Models\Architecture;

use App\Enums\StatusAbonnement;
use App\Enums\StatusEmplacement;
use App\Models\Exploitation\Contrat;
use App\States\Emplacement\StatusDisponibiliteState;
use App\States\Emplacement\StatusLiaisonsState;
use Asantibanez\LaravelEloquentStateMachines\Traits\HasStateMachines;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;

/**
 * @mixin IdeHelperEmplacement
 */
class Emplacement extends Model
{
    use SoftDeletes;
    use HasStateMachines;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;


    public $stateMachines = [
        'disponibilite' => StatusDisponibiliteState::class,
        'liaison' => StatusLiaisonsState::class
    ];

    protected $fillable = ['nom', 'code', 'superficie', 'type_emplacement_id', 'zone_id', 'loyer', 'pas_porte', 'caution'];

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
     * @return Attribut
     */
    protected function code(): Attribute
    {
        return Attribute::make(
            get: fn () => str_pad((string) $this->attributes['code'], 3, '0', STR_PAD_LEFT),
        );
    }

    public function occuper(): void
    {
        $this->disponibilite()->transitionTo(StatusEmplacement::BUSY->value);
    }

    public function liberer(): void
    {
        $this->disponibilite()->transitionTo(StatusEmplacement::FREE->value);
    }

    public function lier(): void
    {
        $this->liaison()->transitionTo(StatusEmplacement::LINKED->value);
    }

    public function delier(): void
    {
        $this->liaison()->transitionTo(StatusEmplacement::UNLINKED->value);
    }

    //scopes

    /**
     * Obtenir les emplacements occupés
     *
     * @param Builder<Emplacement> $query
     * @return Builder<Emplacement>
     */
    public function scopeIsBusy(Builder $query): Builder
    {
        return $query->where('disponibilite', StatusEmplacement::BUSY->value);
    }

    /**
     * Obtenir les emplacements libres
     *
     * @param Builder<Emplacement> $query
     * @return Builder<Emplacement>
     */
    public function scopeIsFree(Builder $query): Builder
    {
        return $query->where('disponibilite', StatusEmplacement::FREE->value);
    }

    /**
     * Obtenir les emplacements liés à au moins un equipement
     *
     * @param Builder<Emplacement> $query
     * @return Builder<Emplacement>
     */
    public function scopeIsLinked(Builder $query): Builder
    {
        return $query->where('liaison', StatusEmplacement::LINKED->value);
    }

    /**
     * Obtenir les emplacements liés à aucun equipement
     *
     * @param Builder<Emplacement> $query
     * @return Builder<Emplacement>
     */
    public function scopeIsUnlinked(Builder $query): Builder
    {
        return $query->where('liaison', StatusEmplacement::UNLINKED->value);
    }

    //relations

    /**
     * Obtenir la zone d'un emplacement
     *
     * @return BelongsTo<Zone, Emplacement>
     */
    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    /**
     * Obtenir le marche de l'emplacement
     *
     * @return HasManyDeep<Site, Emplacement>
     */
    public function site(): HasManyDeep
    {
        return $this->hasManyDeep(
            Site::class,
            [Zone::class, Niveau::class, Pavillon::class],
            ['id', 'id', 'id', 'id'],
            ['zone_id', 'niveau_id', 'pavillon_id', 'site_id'],
        );
    }

    /**
     * Obtenir le type d'un emplacement
     *
     * @return BelongsTo<TypeEmplacement, Emplacement>
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(TypeEmplacement::class, 'type_emplacement_id');
    }

    /**
     * Obtenir les abonnement en cours d'un emplacement
     *
     * @return HasMany<Abonnement, Emplacement>
     */
    public function abonnements(): hasMany
    {
        return $this->hasMany(Abonnement::class);
    }

    /**
     * Obtenir les contrats d'un emplacement
     *
     * @return HasMany<Contrat, Emplacement>
     */
    public function contrats(): HasMany
    {
        return $this->hasMany(Contrat::class);
    }

    /**
     * Obtenir les équipements liés à un emplacement
     *
     * @return HasMany<Equipement, Emplacement>
     */
    public function equipements(): HasMany
    {
        return $this->hasMany(Equipement::class);
    }
}
