<?php

namespace App\Models\Architecture;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pavillon extends Model
{
    use SoftDeletes;

    protected $fillable = ['nom', 'code', 'site_id'];
    protected $dates = ['created_at'];

    const RULES = [
        'nom' => 'required|max:150',
    ];
    const PUSH_RULES = [
        'nombre' => 'required|numeric',
    ];

    public function getCodeAttribute()
    {
        return str_pad($this->id, 2, '0', STR_PAD_LEFT);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function niveaus()
    {
        return $this->hasMany(Niveau::class);
    }
}
