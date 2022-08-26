<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperPaiementLigne
 */
class PaiementLigne extends Model
{
    use HasFactory;

    protected $table = 'paiement_lignes';

    protected $fillable = ['fournisseur', 'code', 'versement_id'];

    /**
     * Undocumented function
     *
     * @return BelongsTo<Versement, PaiementLigne>
     */
    public function versement(): BelongsTo
    {
        return $this->belongsTo(Versement::class);
    }
}
