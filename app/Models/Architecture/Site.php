<?php

namespace App\Models\Architecture;

use App\Models\Exploitation\Personne;
use App\Traits\HasContrats;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;

/**
 * @mixin IdeHelperSite
 */
class Site extends Model implements Auditable
{
    use SoftDeletes;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;
    use HasContrats;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['nom', 'pays', 'ville', 'commune', 'postale'];

    public const RULES = [
        'nom' => 'required|max:255|unique:sites,nom',
        'pays' => 'required',
        'commune' => 'required',
        'ville' => 'required',
    ];

    /**
     * Undocumented function
     *
     * @param  int  $id
     * @return array<string, string>
     */
    public static function edit_rules(int $id): array
    {
        return [
            'nom' => 'required|max:150|unique:sites,nom,' . $id,
            'pays' => 'required',
            'commune' => 'required',
            'ville' => 'required',
        ];
    }

    public function pavillons(): HasMany
    {
        return $this->hasMany(Pavillon::class);
    }

    /**
     * Afficher directement tout les emplacements d'un site (marché)
     */
    public function emplacements(): HasManyDeep
    {
        return $this->hasManyDeep(Emplacement::class, [Pavillon::class, Niveau::class, Zone::class]);
    }

    /**
     * Afficher directement toutes les zones d'un site (marché)
     */
    public function zones(): HasManyDeep
    {
        return $this->hasManyDeep(Zone::class, [Pavillon::class, Niveau::class]);
    }

    public function equipements(): HasMany
    {
        return $this->hasMany(Equipement::class);
    }

    public function personnes(): HasMany
    {
        return $this->hasMany(Personne::class);
    }

    public function abonnements(): HasMany
    {
        return $this->hasMany(Abonnement::class);
    }

    public function servicesAnnexes(): HasMany
    {
        return $this->hasMany(ServiceAnnexe::class);
    }
}
