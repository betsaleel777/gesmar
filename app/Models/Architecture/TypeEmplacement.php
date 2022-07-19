<?php

namespace App\Models\Architecture;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeEmplacement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nom', 'site_id', 'prefix', 'code', 'auto_valid', 'equipable'];
    protected $appends = ['code'];

    const RULES = [
        'nom' => 'required|max:150',
        'site_id' => 'required',
        'prefix' => 'required|max:5|min:2|alpha',
    ];

    public function getCodeAttribute()
    {
        return $this->attributes['prefix'] . str_pad($this->attributes['code'], 2, '0', STR_PAD_LEFT);
    }

    public function scopeEquipables($query)
    {
        return $query->where('equipable', true);
    }

    public function emplacements()
    {
        return $this->hasMany(Emplacement::class, 'type_emplacement_id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
