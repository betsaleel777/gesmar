<?php

namespace App\Models\Architecture;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zone extends Model
{
    use SoftDeletes;

    protected $fillable = ['nom', 'code', 'niveau_id'];
    protected $appends = ['code'];

    const RULES = [
        'nom' => 'required|max:150',
        'niveau_id' => 'required',
    ];
    const MIDDLE_RULES = [
        'niveau_id' => 'required',
        'nombre' => 'required|numeric|min:1',
    ];
    const PUSH_RULES = [
        'nombre' => 'required|numeric|min:1',
    ];

    public function getCodeAttribute()
    {
        return str_pad($this->attributes['code'], 4, '0', STR_PAD_LEFT);
    }

    public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }

    public function emplacements()
    {
        return $this->hasMany(Emplacement::class);
    }
}
