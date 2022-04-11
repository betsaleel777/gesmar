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
        'nom' => 'required|max:150|unique:zones,nom',
        'code' => 'required|email|unique:zones,code',
    ];

    public static function edit_rules(int $id)
    {
        return [
            'nom' => 'required|max:150|unique:zones,nom,' . $id,
            'code' => 'required|email|unique:zones,code,,' . $id,
        ];
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
