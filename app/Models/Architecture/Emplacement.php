<?php

namespace App\Models\Architecture;

use App\Enums\StatusEmplacement;
use App\Models\Bordereau\Bordereau;
use App\Models\Exploitation\Contrat;
use App\Models\Scopes\OwnSiteScope;
use App\Models\Scopes\RecentScope;
use App\States\Emplacement\StatusDisponibiliteState;
use App\States\Emplacement\StatusLiaisonsState;
use App\Traits\HasContrats;
use App\Traits\HasOwnerScope;
use App\Traits\HasResponsible;
use Asantibanez\LaravelEloquentStateMachines\Traits\HasStateMachines;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Staudenmeir\EloquentHasManyDeep\HasOneDeep;

/**
 * @method disponibilite()
 * @method liaison()
 * @mixin IdeHelperEmplacement
 */
class Emplacement extends Model implements Auditable
{
    use SoftDeletes;
    use HasStateMachines;
    use HasResponsible;
    use HasOwnerScope;
    use HasContrats;
    use \OwenIt\Auditing\Auditable;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    /**
     * Summary of stateMachines
     */
    public $stateMachines = ['disponibilite' => StatusDisponibiliteState::class, 'liaison' => StatusLiaisonsState::class];
    protected $fillable = ['nom', 'code', 'superficie', 'type_emplacement_id', 'zone_id', 'loyer', 'pas_porte', 'caution'];

    protected $appends = ['auto'];

    protected $casts = [
        'superficie' => 'integer',
        'loyer' => 'integer',
        'pas_porte' => 'integer',
        'caution' => 'integer',
    ];

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

    protected static function booted(): void
    {
        static::addGlobalScope(new RecentScope);
        static::addGlobalScope(new OwnSiteScope);
    }

    /**
     * @return Attribute<string, never>
     */
    protected function auto(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->relationLoaded('type') and !empty($this->type->auto_valid) ? $this->type->auto_valid : null,
        );
    }

    public function getFullname(): string
    {
        $this->loadMissing('pavillon:id,nom', 'niveau:id,nom', 'site:id,nom');
        return $this->nom . ' ' . str($this->pavillon?->nom)->lower() . ' ' . str($this->niveau?->nom)
            ->lower() . str($this->site?->nom)->lower();
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
     */
    public function scopeIsBusy(Builder $query): Builder
    {
        return $query->where('disponibilite', StatusEmplacement::BUSY->value);
    }

    /**
     * Obtenir les emplacements libres
     */
    public function scopeIsFree(Builder $query): Builder
    {
        return $query->where('disponibilite', StatusEmplacement::FREE->value);
    }

    /**
     * Obtenir les emplacements liés à au moins un equipement
     */
    public function scopeIsLinked(Builder $query): Builder
    {
        return $query->where('liaison', StatusEmplacement::LINKED->value);
    }

    /**
     * Obtenir les emplacements liés à aucun equipement
     */
    public function scopeIsUnlinked(Builder $query): Builder
    {
        return $query->where('liaison', StatusEmplacement::UNLINKED->value);
    }

    /**
     * Obtenir les emplacements d'un marché selon un site précis
     */
    public function scopeBySite(Builder $query, int $id): Builder
    {
        return $query->whereHas('site', fn (Builder $query) => $query->where('sites.id', $id));
    }
    /**
     * Obtenir les emplacements une personne 
     * en retirant les emplacement pour lesquels une demande existe déjà
     */
    public function scopeByPersonneWithoutPending(Builder $query, int $id): Builder
    {
        return $query->whereDoesntHave('contrats', fn (Builder $query) => $query->where('contrats.personne_id', $id)->enAttente());
    }

    /**
     * Obtenir les emplacements qui dont les contrat se valide sans passer par l'ordonnancement
     */
    public function scopeWithoutSchedule(Builder $query): Builder
    {
        return $query->whereHas('type', fn (Builder $query) => $query->where('auto_valid', true));
    }

    public function scopeRemoveAlreadyAssignedToBordereau(Builder $query, int $site, string $jour): Builder
    {
        return $query->whereNotIn('id', fn ($query) => $query->select('emplacements.id')->from('emplacements')
            ->join('bordereau_emplacement', 'bordereau_emplacement.emplacement_id', '=', 'emplacements.id')
            ->join('bordereaux', 'bordereaux.id', '=', 'bordereau_emplacement.bordereau_id')
            ->where('bordereaux.site_id', $site)
            ->where('bordereaux.jour', Carbon::parse($jour)->format('Y-m-d')));
    }

    public function scopeRemoveOtherAlreadyAssignedToBordereau(Builder $query, int $site, int $commercial, string $jour): Builder
    {
        return $query->whereNotIn('id', fn ($query) => $query->select('emplacements.id')->from('emplacements')
            ->join('bordereau_emplacement', 'bordereau_emplacement.emplacement_id', '=', 'emplacements.id')
            ->join('bordereaux', 'bordereaux.id', '=', 'bordereau_emplacement.bordereau_id')
            ->where('bordereaux.site_id', $site)
            ->where('bordereaux.commercial_id', '!=', $commercial)
            ->where('bordereaux.jour', Carbon::parse($jour)->format('Y-m-d')));
    }

    public function scopeRemoveAlreadyCollected(Builder $query, string $jour): Builder
    {
        return $query->whereNotIn('emplacements.id', fn ($query) => $query->select('emplacements.id')->from('emplacements')
            ->join('collectes', 'collectes.emplacement_id', '=', 'emplacements.id')
            ->where('collectes.jour', Carbon::parse($jour)->format('Y-m-d')));
    }

    public function scopeFilterBetweenDisponibilityDate(
        Builder $query,
        ?array $dates,
        string $status = StatusEmplacement::FREE->value
    ): Builder {
        [$start, $end] = $dates;
        return $query->when($dates, fn (Builder $query): Builder =>
        $query->whereHasDisponibilite(fn (Builder $query): Builder =>
        $query->transitionedTo($status)->whereBetween('created_at', [$start, $end])));
    }

    public function scopeFilterBetweenLiaisonDate(
        Builder $query,
        ?array $dates,
        string $status = StatusEmplacement::LINKED->value
    ): Builder {
        [$start, $end] = $dates;
        return $query->when($dates, fn (Builder $query): Builder =>
        $query->whereHasLiaison(fn (Builder $query): Builder => $query->transitionedTo($status)
            ->whereBetween('created_at', [$start, $end])));
    }

    public function scopeFilterBetweenSubscribeDate(Builder $query, ?array $dates, bool $subscribed = true): Builder
    {
        [$start, $end] = $dates;
        $hasBetween = $subscribed ? fn (Builder $query) => $query->whereHas('abonnementsActuels', fn (Builder $query): Builder => $query->whereBetween('created_at', [$start, $end])) : $query->whereDoesntHave('abonnementsActuels', fn (Builder $query): Builder => $query->whereBetween('created_at', [$start, $end]));
        return $query->when($dates, fn (Builder $query): Builder => $hasBetween($query));
    }

    //relations
    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    public function niveau(): HasOneDeep
    {
        return $this->hasOneDeep(
            Niveau::class,
            [Zone::class],
            ['id', 'id'],
            ['zone_id', 'niveau_id'],
        );
    }

    public function pavillon(): HasOneDeep
    {
        return $this->hasOneDeep(
            Pavillon::class,
            [Zone::class, Niveau::class],
            ['id', 'id', 'id'],
            ['zone_id', 'niveau_id', 'pavillon_id'],
        );
    }
    /**
     * Obtenir le marche de l'emplacement
     */
    public function site(): HasOneDeep
    {
        return $this->hasOneDeep(
            Site::class,
            [Zone::class, Niveau::class, Pavillon::class],
            ['id', 'id', 'id', 'id'],
            ['zone_id', 'niveau_id', 'pavillon_id', 'site_id'],
        );
    }

    /**
     * Obtenir le type d'un emplacement
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(TypeEmplacement::class, 'type_emplacement_id');
    }

    /**
     * Obtenir les abonnements d'un emplacement
     */
    public function abonnements(): hasMany
    {
        return $this->hasMany(Abonnement::class);
    }

    /**
     * Obtenir les abonnements en cours pour un emplacement
     * TODO: vérifier si le contrat lié à l'abonnement est en cours pour l'emplacement en question
     */
    public function abonnementsActuels(): hasMany
    {
        return $this->hasMany(Abonnement::class)->progressing();
    }

    public function contrats(): HasMany
    {
        return $this->hasMany(Contrat::class);
    }

    /**
     * Obtenir le contrat en cours sur un emplacement
     */
    public function contratActuel(): HasOne
    {
        return $this->hasOne(Contrat::class)->validated();
    }

    /**
     * Obtenir le contrat en cours sur un emplacement
     */
    public function contratPending(): HasOne
    {
        return $this->hasOne(Contrat::class)->enAttente();
    }

    /**
     * Obtenir les équipements liés à un emplacement
     */
    public function equipements(): HasMany
    {
        return $this->hasMany(Equipement::class);
    }

    public function bordereaux(): BelongsToMany
    {
        return $this->belongsToMany(Bordereau::class, 'bordereau_emplacement', 'emplacement_id', 'bordereau_id');
    }
}
