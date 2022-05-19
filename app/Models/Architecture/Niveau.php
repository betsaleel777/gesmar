<?php

namespace App\Models\Architecture;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Niveau extends Model
{
    use SoftDeletes;

    protected $fillable = ['nom', 'code', 'pavillon_id'];

    protected $dates = ['created_at'];

    const RULES = [
        'nom' => 'required|max:150',
        'pavillon_id' => 'required',
    ];
    const MIDDLE_RULES = [
        'pavillon_id' => 'required',
        'nombre' => 'required|numeric|min:1',
    ];
    const PUSH_RULES = [
        'nombre' => 'required|numeric|min:1',
    ];

    public function pavillon()
    {
        return $this->belongsTo(Pavillon::class);
    }

    public function zones()
    {
        return $this->hasMany(Zone::class);
    }
}
