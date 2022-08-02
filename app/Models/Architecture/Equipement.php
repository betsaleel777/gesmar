<?php

namespace App\Models\Architecture;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @mixin IdeHelperEquipement
 */
class Equipement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nom',
        'code',
        'prix_unitaire',
        'prix_fixe',
        'frais_facture',
        'index',
        'type_equipement_id',
        'site_id',
        'date_occupe',
        'date_abime',
        'date_libre',
    ];

    /**
     * Undocumented variable
     *
     * @var array<int, string>
     */
    protected $appends = ['status'];

    const FREE = 'libre';

    const BUSY = 'occupé';

    const DAMAGING = 'abimé';

    const RULES = [
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
     * @return Attribute{get:(callable(): string)}
     */
    protected function status(): Attribute
    {
        return new Attribute(
            get:function () {
                if (empty($this->attributes['date_occupe']) and empty($this->attributes['date_abime'])) {
                    return self::FREE;
                }
                if (!empty($this->attributes['date_occupe'])) {
                    return self::BUSY;
                }
            }
        );
    }

    public function busy(): void
    {
        $this->attributes['date_occupe'] = Carbon::now();
        $this->attributes['date_abime'] = null;
        $this->attributes['date_libre'] = null;
    }

    public function damaging(): void
    {
        $this->attributes['date_abime'] = Carbon::now();
        $this->attributes['date_occupe'] = null;
        $this->attributes['date_libre'] = null;
    }

    public function free(): void
    {
        $this->attributes['date_libre'] = Carbon::now();
        $this->attributes['date_abime'] = null;
        $this->attributes['date_occupe'] = null;
    }

    /**
     * Undocumented function
     *
     * @param  Builder<Equipement>  $query
     * @return Builder<Equipement>
     */
    public function socpeIsFree(Builder $query): Builder
    {
        return $query->whereNotNull('date_libre');
    }

    /**
     * Undocumented function
     *
     * @param  Builder<Equipement>  $query
     * @return Builder<Equipement>
     */
    public function socpeIsDamaged(Builder $query): Builder
    {
        return $query->whereNotNull('date_abime');
    }

    /**
     * Undocumented function
     *
     * @param  Builder<Equipement>  $query
     * @return Builder<Equipement>
     */
    public function socpeIsBusy(Builder $query): Builder
    {
        return $query->whereNotNull('date_occupe');
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo<TypeEquipement>
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(TypeEquipement::class, 'type_equipement_id');
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
