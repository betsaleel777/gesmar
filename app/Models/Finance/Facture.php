<?php

namespace App\Models\Finance;

use App\Models\Architecture\Equipement;
use App\Models\Architecture\ServiceAnnexe;
use App\Models\Exploitation\Contrat;
use App\Models\Finance\Versement;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;
    protected $fillable = [
        'code', 'contrat_id', 'date_soldee', 'annexe_id', 'date_facture', 'index_debut', 'index_fin',
        'equipement_id', 'avance', 'caution', 'pas_porte', 'date_plan', 'periode',
    ];
    protected $appends = ['status'];
    private const PAID = 'payée';
    private const UNPAID = 'impayée';
    const SHEDULABLE = 'planifiable';
    const RULES = [
        'contrat_id' => 'required',
    ];

    public function codeGenerate(string $prefix)
    {
        $rang = $this->get()->count() + 1;
        $this->attributes['code'] = $prefix . str_pad($rang, 7, '0', STR_PAD_LEFT);
    }

    public static function initialeRules()
    {
        return array_merge(self::RULES, [
            'avance' => 'required|numeric',
            'caution' => 'required|numeric',
            'pas_porte' => 'required|numeric',
        ]);
    }

    public static function loyerRules()
    {
        return array_merge(self::RULES, ['periode' => 'required']);
    }

    public function payer(): void
    {
        $this->attributes['date_soldee'] = Carbon::now();
    }

    public function planifier(): void
    {
        $this->attributes['date_plan'] = Carbon::now();
    }

    public function getStatusAttribute()
    {
        if ($this->attributes['date_plan']) {
            return self::SHEDULABLE;
        }
    }

    // scopes

    public function scopeSoldees($query)
    {
        return $query->whereNotNull('date_soldee');
    }

    public function scopeValidees($query)
    {
        return $query->whereNotNull('date_facture');
    }

    public function scopeNonValidees($query)
    {
        return $query->whereNull('date_facture');
    }

    public function scopeIsAnnexe($query)
    {
        return $query->whereNotNull('annexe_id');
    }

    public function scopeIsEquipement($query)
    {
        return $query->whereNotNull('equipement_id');
    }

    public function scopeIsInitiale($query)
    {
        return $query->whereNull('annexe_id')->whereNull('periode')->whereNull('equipement_id');
    }

    public function scopeIsLoyer($query)
    {
        return $query->whereNotNull('periode')->whereNull('equipement_id');
    }

    // relations
    public function annexe()
    {
        return $this->belongsTo(ServiceAnnexe::class);
    }

    public function equipement()
    {
        return $this->belongsTo(Equipement::class);
    }

    public function contrat()
    {
        return $this->belongsTo(Contrat::class);
    }

    public function versements()
    {
        return $this->hasMany(Versement::class);
    }

}
