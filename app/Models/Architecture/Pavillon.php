<?php

namespace App\Models\Architecture;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pavillon extends Model
{
    use SoftDeletes;

    protected $fillable = ['nom', 'code', 'site_id'];
    protected $appends = ['code'];

    const RULES = [
        'nom' => 'required|max:150',
        'site_id' => 'required',
    ];
    const MIDDLE_RULES = [
        'site_id' => 'required',
        'nombre' => 'required|numeric|min:1',
    ];
    const PUSH_RULES = [
        'nombre' => 'required|numeric|min:1',
    ];

    public function getCodeAttribute()
    {
        return str_pad($this->attributes['code'], 2, '0', STR_PAD_LEFT);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function niveaux()
    {
        return $this->hasMany(Niveau::class);
    }
}
