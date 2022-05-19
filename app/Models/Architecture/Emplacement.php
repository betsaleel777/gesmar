<?php

namespace App\Models\Architecture;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emplacement extends Model
{
    use SoftDeletes;

    protected $fillable = ['nom', 'code', 'superficie', 'type_emplacement_id', 'zone_id', 'reserved', 'busy', 'loyer', 'pas_porte'];

    protected $dates = ['created_at'];

    const RULES = [
        'nom' => 'required|max:255',
        'superficie' => 'required',
        'loyer' => 'required',
        'pas_porte' => 'required',
        'zone_id' => 'required',
        'type_emplacement_id' => 'required',
    ];

    public function getCodeAttribute()
    {
        return str_pad($this->attributes['code'], 3, '0', STR_PAD_LEFT);
    }

    public function zone()
    {
        return $this->hasMany(Zone::class);
    }

    public function type()
    {
        return $this->belongsTo(TypeEmplacement::class);
    }
}
