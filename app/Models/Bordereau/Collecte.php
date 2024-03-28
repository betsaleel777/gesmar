<?php

namespace App\Models\Bordereau;

use App\Models\Architecture\Emplacement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as ContractsAuditable;

/**
 * @mixin IdeHelperCollecte
 */
class Collecte extends Model implements ContractsAuditable
{
    use Auditable;
    protected $fillable = ['bordereau_id', 'emplacement_id', 'jour', 'montant'];
    protected $dates = ['created_at'];
    protected $casts = ['jour' => 'date', 'montant' => 'integer'];

    public function bordereau(): BelongsTo
    {
        return $this->belongsTo(Bordereau::class);
    }

    public function emplacement(): BelongsTo
    {
        return $this->belongsTo(Emplacement::class);
    }
}
