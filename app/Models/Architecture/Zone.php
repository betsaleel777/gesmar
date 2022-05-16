<?php

namespace App\Models\Architecture;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zone extends Model
{
    use SoftDeletes;

    protected $fillable = ['nom', 'code', 'niveau_id'];

    protected $dates = ['created_at'];
    const RULES = [
        'nom' => 'required|max:150',
    ];

    public function getCodeAttribute()
    {
        return str_pad($this->id, 4, '0', STR_PAD_LEFT);
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
