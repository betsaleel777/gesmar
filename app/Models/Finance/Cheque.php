<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cheque extends Model
{
    use HasFactory;
    protected $fillable = ['numero', 'banque', 'encaisse'];

    const RULES = [
        'numero' => 'required',
        'banque' => 'required',
    ];

    public function valider(): void
    {
        $this->attributes['encaisser'] = true;
    }

    public function isValid($query)
    {
        return $query->where('encaisse', true);
    }
}
