<?php

namespace App\Models\Architecture;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeEquipement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nom', 'site_id', 'frais_penalite'];

    const RULES = [
        'nom' => 'required|max:150',
        'site_id' => 'required',
        'frais_penalite' => 'required|min:1|max:100',
    ];

    public function equipements()
    {
        return $this->hasMany(Equipement::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
