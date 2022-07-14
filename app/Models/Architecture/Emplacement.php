<?php

namespace App\Models\Architecture;

use App\Models\Exploitation\ContratEmplacement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emplacement extends Model
{
    use SoftDeletes;

    protected $fillable = ['nom', 'code', 'superficie', 'type_emplacement_id', 'zone_id', 'reserved', 'busy', 'loyer', 'pas_porte', 'caution'];

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

    public function getCodeAttribute()
    {
        return str_pad($this->attributes['code'], 3, '0', STR_PAD_LEFT);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function type()
    {
        return $this->belongsTo(TypeEmplacement::class, 'type_emplacement_id');
    }

    public function equipements()
    {
        return $this->belongsToMany(Equipement::class, 'abonnements')->wherePivotNull('date_resiliation')
            ->using(Abonnement::class)->withTimestamps();
    }

    public function pacte()
    {
        return $this->belongsTo(ContratEmplacement::class);
    }
}
