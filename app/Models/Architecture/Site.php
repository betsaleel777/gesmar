<?php

namespace App\Models\Architecture;

use App\Models\Exploitation\Contrat;
use App\Models\Exploitation\Personne;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperSite
 */
class Site extends Model
{
    use SoftDeletes;

    protected $fillable = ['nom', 'pays', 'ville', 'commune', 'postale'];

    const RULES = [
        'nom' => 'required|max:255|unique:sites,nom',
        'pays' => 'required',
        'commune' => 'required',
        'ville' => 'required',
    ];

    public static function edit_rules(int $id): array
    {
        return [
            'nom' => 'required|max:150|unique:sites,nom,' . $id,
            'pays' => 'required',
            'commune' => 'required',
            'ville' => 'required',
        ];
    }

    /**
     * Undocumented function
     *
     * @return HasMany<int Collection<int,Pavillon>>
     */
    public function pavillons(): HasMany
    {
        return $this->hasMany(Pavillon::class);
    }

    /**
     * Undocumented function
     *
     * @return HasMany<int, Collection<int,Equipement>>
     */
    public function equipements(): HasMany
    {
        return $this->hasMany(Equipement::class);
    }

    /**
     * Undocumented function
     *
     * @return HasMany<int, Collection<int, Personne>>
     */
    public function personnes(): HasMany
    {
        return $this->hasMany(Personne::class);
    }

    /**
     * Undocumented function
     *
     * @return HasMany<int, Collection<int, Contrat>>
     */
    public function contrats(): HasMany
    {
        return $this->hasMany(Contrat::class);
    }

    /**
     * Undocumented function
     *
     * @return HasMany<int, Collection<int, Abonnement>>
     */
    public function abonnements(): HasMany
    {
        return $this->hasMany(Abonnement::class);
    }

    /**
     * Undocumented function
     *
     * @return HasMany<int, Collection<int, ServiceAnnexe>>
     */
    public function servicesAnnexes(): HasMany
    {
        return $this->hasMany(ServiceAnnexe::class);
    }
}
