<?php

namespace App\Models\Architecture;

use App\Models\Exploitation\ContratAnnexe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceAnnexe extends Model
{
    use SoftDeletes;

    protected $fillable = ['nom', 'site_id', 'prix', 'description', 'mode'];
    protected $dates = ['created_at'];

    const RULES = [
        'nom' => 'required|max:250',
        'prix' => 'required',
        'site_id' => 'required',
        'mode' => 'required',
    ];
    const MENSUEL = 'par mois';
    const QUOTIDIEN = 'par jour';
    const FORFAIT = 'forfaitaire';

    public function forfaitaire()
    {
        $this->attributes['mode'] = self::FORFAIT;
    }
    public function quotidien()
    {
        $this->attributes['mode'] = self::QUOTIDIEN;
    }
    public function mensuel()
    {
        $this->attributes['mode'] = self::MENSUEL;
    }
    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function contrats()
    {
        return $this->hasMany(ContratAnnexe::class);
    }
}
