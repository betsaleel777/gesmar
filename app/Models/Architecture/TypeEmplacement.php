<?php

namespace App\Models\Architecture;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeEmplacement extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

    protected $dates = ['created_at'];

    const RULES = [
        'nom' => 'required|max:150',
    ];

    public function emplacements()
    {
        return $this->hasMany(Emplacement::class);
    }
}
