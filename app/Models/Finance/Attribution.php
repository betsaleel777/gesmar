<?php

namespace App\Models\Finance;

use App\Enums\StatusBordereau;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\ModelStatus\HasStatuses;

class Attribution extends Model
{
    use  HasStatuses;

    protected $fillable = ['commercial_id', 'emplacement_id', 'jour'];
    protected $table = 'attribution_emplacements';

    public function encaisser(): void
    {
        $this->setStatus(StatusBordereau::ENCAISSE->value);
    }

    public function pasEncaisser(): void
    {
        $this->setStatus(StatusBordereau::PAS_ENCAISSE->value);
    }

    /**
     * Obtenir les commerciaux d'une attribution d'emplacement
     *
     * @return BelongsTo<Commercial, Attribution>
     */
    public function commercial(): BelongsTo
    {
        return $this->belongsTo(Commercial::class);
    }

    /**
     * Obtenir les commerciaux d'une attribution d'emplacement
     *
     * @return BelongsTo<Commercial, Attribution>
     */
    public function emplacement(): BelongsTo
    {
        return $this->belongsTo(Emplacement::class);
    }
}
