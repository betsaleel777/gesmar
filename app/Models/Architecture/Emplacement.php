<?php

namespace App\Models\Architecture;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emplacement extends Model
{
    use SoftDeletes;

    protected $fillable = ['nom', 'code', 'pays', 'ville', 'commune', 'postale'];

    protected $dates = ['created_at'];

    const RULES = [
        'nom' => 'required|max:255',
        'code' => 'required|email|unique:emplacements,code',
        'pays' => 'required',
        'commune' => 'required',
        'ville' => 'required',
    ];

    public static function edit_rules(int $id)
    {
        return [
            'nom' => 'required|max:150',
            'code' => 'required|email|unique:emplacements,code,' . $id,
            'pays' => 'required',
            'commune' => 'required',
            'ville' => 'required',
        ];
    }

    public function pavillons()
    {
        return $this->hasMany(Pavillon::class);
    }
}
