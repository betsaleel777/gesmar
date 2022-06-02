<?php

namespace App\Models\Architecture;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Site extends Model
{
    use SoftDeletes;

    protected $fillable = ['nom', 'pays', 'ville', 'commune', 'postale'];
    protected $dates = ['created_at'];

    const RULES = [
        'nom' => 'required|max:255|unique:sites,nom',
        'pays' => 'required',
        'commune' => 'required',
        'ville' => 'required',
    ];

    public static function edit_rules(int $id)
    {
        return [
            'nom' => 'required|max:150|unique:sites,nom,' . $id,
            'pays' => 'required',
            'commune' => 'required',
            'ville' => 'required',
        ];
    }

    public function pavillons()
    {
        return $this->hasMany(Pavillon::class);
    }

    public function equipements()
    {
        return $this->hasMany(Equipement::class);
    }
}
