<?php

namespace App\Models\Architecture;

use App\Enums\StatusEquipement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStatus\HasStatuses;

/**
 * @mixin IdeHelperEquipement
 */
class Equipement extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasStatuses;

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
     * Undocumented variable
     *
     * @var array<int, string>
     */
    protected $appends = ['alias','statuts'];

    /**
     * Undocumented variable
     *
     * @var array<int, string>
     */
    protected $with = ['type','statuses'];

    public const RULES = [
        'prix_unitaire' => 'required|numeric',
        'prix_fixe' => 'required|numeric',
        'frais_facture' => 'required',
        'type_equipement_id' => 'required',
        'index' => 'required',
        'site_id' => 'required',
    ];
    /**
     * Undocumented function
     *
     * @return Attribute<mixed>
     */
    protected function alias(): Attribute
    {
        return Attribute::make(
            get:fn () => $this->attributes['code'] . ' ' . $this->type->nom,
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
                $status[] = $this->latestStatus(StatusEquipement::SUBSCRIBED->value, StatusEquipement::UNSUBSCRIBED->value);
                $status[] = $this->latestStatus(StatusEquipement::LINKED->value, StatusEquipement::UNLINKED->value);
                return $status;
            }
        );
    }

    public function abonner(): void
    {
        $this->setStatus(StatusEquipement::SUBSCRIBED->value);
    }

    public function desabonner(): void
    {
        $this->setStatus(StatusEquipement::UNSUBSCRIBED->value);
    }

    public function lier(): void
    {
        $this->setStatus(StatusEquipement::LINKED->value);
    }

    public function delier(): void
    {
        $this->setStatus(StatusEquipement::UNLINKED->value);
    }

    public function endommager(): void
    {
        $this->setStatus(StatusEquipement::DAMAGED->value);
    }

    public function reparer(): void
    {
        $this->setStatus(StatusEquipement::FIXED->value);
    }

    // scopes

    /**
     * obtenir les equipements qui ont un abonnement en cours
     *
     * @param Builder<Equipement> $query
     * @return Builder<Equipement>
     */
    public function scopeIsSubscribed(Builder $query): Builder
    {
        return $query->whereHas('statuses', function ($query) {
            return $query->where('name', StatusEquipement::SUBSCRIBED->value) ;
        });
    }

    /**
     * obtenir les equipements qui n'ont pas d'abonnement en cours
     *
     * @param Builder<Equipement> $query
     * @return Builder<Equipement>
     */
    public function scopeIsUnsubscribed(Builder $query): Builder
    {
        return $query->whereHas('statuses', function ($query) {
            return $query->where('name', StatusEquipement::UNSUBSCRIBED->value) ;
        });
    }

    /**
     * obtenir les equipements qui sont liés à un emplacement
     *
     * @param Builder<Equipement> $query
     * @return Builder<Equipement>
     */
    public function scopeIsLinked(Builder $query): Builder
    {
        return $query->whereHas('statuses', function ($query) {
            return $query->where('name', StatusEquipement::LINKED->value) ;
        });
    }

    /**
     * obtenir les equipements qui ne sont pas liés à un emplacement
     *
     * @param Builder<Equipement> $query
     * @return Builder<Equipement>
     */
    public function scopeIsUnlinked(Builder $query): Builder
    {
        return $query->whereHas('statuses', function ($query) {
            return $query->where('name', StatusEquipement::UNLINKED->value) ;
        });
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
