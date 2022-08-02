<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCheque
 */
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

    /**
     * Undocumented function
     *
     * @param Builder<Cheque> $query
     * @return Builder<Cheque>
     */
    public function isValid(Builder $query): Builder
    {
        return $query->where('encaisse', true);
    }
}
