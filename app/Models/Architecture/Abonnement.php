<?php

namespace App\Models\Architecture;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Abonnement extends Model
{
    use SoftDeletes;
    protected $fillable = ['code', 'equipement_id', 'emplacement_id', 'index_depart', 'index_fin', 'index_autre', 'date_resiliation', 'site_id'];
    protected $appends = ['status'];
    protected $dates = ['created_at'];
    const PROGRESSING = 'en cours';
    const STOPPED = 'résilié';
    const RULES = [
        'equipement_id' => 'required',
        'emplacement_id' => 'required',
        'index_depart' => 'required|numeric',
        'site_id' => 'required',
    ];
    const FINISH_RULES = [
        'index_fin' => 'required|numeric',
    ];

    public function stop()
    {
        $this->attributes['date_resiliation'] = Carbon::now();
    }

    public function process()
    {
        $this->attributes['date_resiliation'] = null;
    }

    public function getStatusAttribute()
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

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
