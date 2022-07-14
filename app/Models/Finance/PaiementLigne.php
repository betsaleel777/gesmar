<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaiementLigne extends Model
{
    use HasFactory;
    protected $table = 'paiement_lignes';
    protected $fillable = ['fournisseur', 'code', 'versement_id'];

    public function versement()
    {
        return $this->belongsTo(Versement::class);
    }
}
