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
        'nom' => 'required|max:150|unique:niveaus,nom',
    ];

    const PUSH_RULES = [
        'nombre' => 'required|numeric',
    ];

    public static function edit_rules(int $id)
    {
        return [
            'nom' => 'required|max:150|unique:niveaus,nom,' . $id,
        ];
    }

    public function pavillon()
    {
        return $this->belongsTo(Pavillon::class);
    }

    public function zones()
    {
        return $this->hasMany(Zone::class);
    }
}
