<?php

namespace App\Models\Architecture;

use App\Models\Exploitation\ContratAnnexe;
use App\Models\Exploitation\ContratEmplacement;
use App\Models\Exploitation\Personne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Site extends Model
{
    use SoftDeletes;

    protected $fillable = ['nom', 'pays', 'ville', 'commune', 'postale'];
    protected $dates = ['created_at'];

    const RULES = [
        'nom' => 'required|max:255|unique:sites,nom',
        'pays' => 'required',
        'commune' => 'required',
        'ville' => 'required',
    ];

    public static function edit_rules(int $id)
    {
        return [
            'nom' => 'required|max:150|unique:sites,nom,' . $id,
            'pays' => 'required',
            'commune' => 'required',
            'ville' => 'required',
        ];
    }

    public function pavillons()
    {
        return $this->hasMany(Pavillon::class);
    }

    public function equipements()
    {
        return $this->hasMany(Equipement::class);
    }

    public function personnes()
    {
        return $this->hasMany(Personne::class);
    }

    public function contratsAnnexes()
    {
        return $this->hasMany(ContratAnnexe::class);
    }

    public function contratsEmplacements()
    {
        return $this->hasMany(ContratEmplacement::class);
    }

    public function abonnements()
    {
        return $this->hasMany(Abonnement::class);
    }

    public function servicesAnnexes()
    {
        return $this->hasMany(ServiceAnnexe::class);
    }

}
