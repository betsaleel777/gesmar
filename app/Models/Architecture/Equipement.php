<?php

namespace App\Models\Architecture;

use App\Enums\StatusEquipement;
use App\Models\Finance\Facture;
use App\States\Equipement\StatusAbonnementState;
use App\States\Equipement\StatusLiaisonsState;
use Asantibanez\LaravelEloquentStateMachines\Traits\HasStateMachines;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperEquipement
 */
class Equipement extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasStateMachines;

    /**
     *
     * @var array<string, string>
     */
    public $stateMachines = [
        'abonnement' => StatusAbonnementState::class,
        'liaison' => StatusLiaisonsState::class
    ];

    protected $fillable = [
        'nom',
        'code',
        'prix_unitaire',
        'prix_fixe',
        'frais_facture',
        'index',
        'type_equipement_id',
        'site_id',
        'emplacement_id',
    ];

    /**
     *
     * @var array<int, string>
     */
    protected $appends = ['alias'];

    /**
     *
     * @var array<int, string>
     */
    protected $with = ['type'];

    public const RULES = [
        'prix_unitaire' => 'required|numeric',
        'prix_fixe' => 'required|numeric',
        'frais_facture' => 'required',
        'type_equipement_id' => 'required',
        'index' => 'required',
        'site_id' => 'required',
    ];

    protected static function booted(): void
    {
        static::deleted(function (Equipement $equipement): void {
            Emplacement::findOrFail($equipement->emplacement_id)->delier();
            Facture::whereHas('equipement', fn ($query) => $query->where('equipement_id', $equipement->id))->get()->all()->map->delete();
        });
    }
    /**
     *
     * @return Attribute<string, never>
     */
    protected function alias(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->attributes['code'] . ' ' . $this->type->nom,
        );
    }

    public function abonner(): void
    {
        $this->abonnement()->transitionTo(StatusEquipement::SUBSCRIBED->value);
    }

    public function desabonner(): void
    {
        $this->abonnement()->transitionTo(StatusEquipement::UNSUBSCRIBED->value);
    }

    public function lier(): void
    {
        $this->liaison()->transitionTo(StatusEquipement::LINKED->value);
    }

    public function delier(): void
    {
        $this->liaison()->transitionTo(StatusEquipement::UNLINKED->value);
    }

    // scopes

    /**
     * Obtenir les equipements qui ont un abonnement en cours
     *
     * @param Builder<Equipement> $query
     * @return Builder<Equipement>
     */
    public function scopeSubscribed(Builder $query): Builder
    {
        return $query->where('abonnement', StatusEquipement::SUBSCRIBED->value);
    }

    /**
     * Obtenir les equipements qui n'ont pas d'abonnement en cours
     *
     * @param Builder<Equipement> $query
     * @return Builder<Equipement>
     */
    public function scopeUnsubscribed(Builder $query): Builder
    {
        return $query->where('abonnement', StatusEquipement::UNSUBSCRIBED->value);
    }

    /**
     * Obtenir les equipements qui sont liés à un emplacement
     *
     * @param Builder<Equipement> $query
     * @return Builder<Equipement>
     */
    public function scopeLinked(Builder $query): Builder
    {
        return $query->where('liaison', StatusEquipement::LINKED->value);
    }

    /**
     * Obtenir les equipements qui ne sont pas liés à un emplacement
     *
     * @param Builder<Equipement> $query
     * @return Builder<Equipement>
     */
    public function scopeUnlinked(Builder $query): Builder
    {
        return $query->where('liaison', StatusEquipement::UNLINKED->value);
    }


    /**
     * Undocumented function
     *
     * @return BelongsTo<TypeEquipement, Equipement>
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(TypeEquipement::class, 'type_equipement_id');
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo<Site, Equipement>
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo<Emplacement, Equipement>
     */
    public function emplacement(): BelongsTo
    {
        return $this->belongsTo(Emplacement::class);
    }
}