<?php

namespace App\Models\Finance;

use App\Models\Caisse\Encaissement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Espece extends Model
{
    use HasFactory;
    protected $fillable = ['montant', 'versement'];

    const RULES = [
        'montant' => 'required',
        'versement' => 'required',
    ];

    public function encaissement(): MorphOne
    {
        return $this->morphOne(Encaissement::class, 'payable');
    }
}
