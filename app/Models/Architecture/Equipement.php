<?php

namespace App\Models\Architecture;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Equipement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nom',
        'code',
        'prix_unitaire',
        'prix_fixe',
        'frais_facture',
        'index',
        'type_equipement_id',
        'site_id',
        'date_occupe',
        'date_abime',
        'date_libre',
    ];
    protected $appends = ['status'];
    protected $dates = ['created_at'];
    const FREE = 'libre';
    const BUSY = 'occupé';
    const DAMAGING = 'abimé';
    const RULES = [
        'prix_unitaire' => 'required|numeric',
        'prix_fixe' => 'required|numeric',
        'frais_facture' => 'required',
        'type_equipement_id' => 'required',
        'index' => 'required',
        'site_id' => 'required',
    ];

    public function getStatusAttribute()
    {
        if (empty($this->attributes['date_occupe']) and empty($this->attributes['date_abime'])) {
            return self::FREE;
        }

        if (!empty($this->attributes['date_occupe'])) {
            return self::BUSY;
        }

    }

    public function socpeIsFree($query)
    {
        return $query->whereNotNull('date_libre');
    }

    public function socpeIsDamaged($query)
    {
        return $query->whereNotNull('date_abime');
    }

    public function socpeIsBusy($query)
    {
        return $query->whereNotNull('date_occupe');
    }

    public function busy(): void
    {
        $this->attributes['date_occupe'] = Carbon::now();
        $this->attributes['date_abime'] = null;
        $this->attributes['date_libre'] = null;
    }

    public function damaging(): void
    {
        $this->attributes['date_abime'] = Carbon::now();
        $this->attributes['date_occupe'] = null;
        $this->attributes['date_libre'] = null;
    }

    public function free(): void
    {
        $this->attributes['date_libre'] = Carbon::now();
        $this->attributes['date_abime'] = null;
        $this->attributes['date_occupe'] = null;
    }

    public function type()
    {
        return $this->belongsTo(TypeEquipement::class, 'type_equipement_id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
