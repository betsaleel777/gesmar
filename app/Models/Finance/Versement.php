<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Versement extends Model
{
    use HasFactory;
    protected $table = 'versements';
    protected $fillable = ['montant', 'monnaie', 'espece', 'facture_id'];
    const RULES = [
        'monnaie' => 'nullable|lt:espece|numeric',
        'montant' => 'required|numeric',
        'espece' => 'nullable|numeric',
        'facture_id' => 'required',
    ];

    // scope

    public function scopeIsAnnexe($query)
    {
        return $query->whith(['facture' => function ($query) {return $query->whereNotNull('annexe_id');}]);
    }

    public function scopeIsInitiale($query)
    {
        return $query->whith(['facture' => function ($query) {
            return $query->whereNull('annexe_id')->whereNull('periode')->whereNull('equipement_id');},
        ]);
    }

    public function scopeIsEquipement($query)
    {
        return $query->whith(['facture' => function ($query) {return $query->whereNotNull('equipement_id');}]);
    }

    public function scopeIsLoyer($query)
    {
        return $query->whith(['facture' => function ($query) {return $query->whereNotNull('periode');}]);
    }

    // relations

    public function facture()
    {
        return $this->belongsTo(Facture::class);
    }
}
