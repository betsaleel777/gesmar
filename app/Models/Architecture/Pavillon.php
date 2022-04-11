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
        'nom' => 'required|max:150|unique:pavillons,nom',
        'code' => 'required|email|unique:pavillons,code',
    ];

    public static function edit_rules(int $id)
    {
        return [
            'nom' => 'required|max:150|unique:pavillons,nom,' . $id,
            'code' => 'required|email|unique:pavillons,code,,' . $id,
        ];
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
