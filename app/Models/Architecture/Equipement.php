<?php

namespace App\Models\Architecture;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'emplacement_id',
        'type_equipement_id',
    ];

    protected $dates = ['created_at'];

    const RULES = [
        'nom' => 'required|max:255',
        'code' => 'required',
        'prix_unitaire' => 'required|numeric',
        'prix_fixe' => 'required|numeric',
        'frais_facture' => 'required',
        'emplacement_id' => 'required',
        'type_equipement_id' => 'required',
        'index' => 'required',
    ];

    // public function getCodeAttribute()
    // {
    //     return str_pad($this->attributes['code'], 3, '0', STR_PAD_LEFT);
    // }

    public function emplacement()
    {
        return $this->belongsTo(Emplacement::class);
    }

    public function type()
    {
        return $this->belongsTo(TypeEquipement::class);
    }
}
