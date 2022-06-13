<?php

namespace App\Models\Architecture;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Abonnement extends Model
{
    use SoftDeletes;
    protected $fillable = ['code', 'equipement', 'emplacement', 'index_depart', 'index_fin', 'date_resiliation', 'site_id'];
    protected $appends = ['status'];
    protected $dates = ['created_at'];
    const PROGRESSING = 'en cours';
    const STOPPED = 'résilié';
    const RULES = [
        'code' => 'required',
        'equipement' => 'required',
        'emplacement' => 'required',
        'index_depart' => 'required|numeric',
        'index_fin' => 'nullable|numeric',
        'date_resiliation' => 'required',
        'site_id' => 'required',
    ];

    public function getStatusAttributes()
    {
        return empty($this->attributes['date_resiliation']) ? self::PROGRESSING : self::STOPPED;
    }

    public function scopeResilies($query)
    {
        return $query->whereNotNull('date_resiliation');
    }

    public function scopeEnCours($query)
    {
        return $query->whereNull('date_resiliation');
    }

    public function equipement()
    {
        return $this->belongsTo(Equipement::class);
    }

    public function emplacement()
    {
        return $this->belongsTo(Emplacement::class);
    }
}
