<?php

namespace App\Models\Finance;

use App\Enums\StatusBordereau;
use App\Models\Architecture\Emplacement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\ModelStatus\HasStatuses;


class Attribution extends Model
{
    use HasStatuses;

    protected $fillable = ['commercial_id', 'emplacement_id', 'jour'];
    protected $table = 'attribution_emplacements';
    /**
     *
     * @var array<int, string>
     */
    protected $appends = ['status'];

    const RULES = [
        'jour' => 'required',
        'zones' => 'required',
    ];
    const TRANSFERT_RULES = [
        'commercial_id' => 'required',
        'date' => 'required',
    ];

    public function encaisser(): void
    {
        $this->setStatus(StatusBordereau::ENCAISSE->value);
    }

    public function pasEncaisser(): void
    {
        $this->setStatus(StatusBordereau::PAS_ENCAISSE->value);
    }

    public function cashed()
    {
        return $this->status === StatusBordereau::ENCAISSE->value;
    }

    public function uncashed()
    {
        return $this->status === StatusBordereau::PAS_ENCAISSE->value;
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

    /**
     * Obtenir le bordereau d'une attribution d'emplacement
     *
     * @return BelongsTo<Bordereau, Attribution>
     */
    public function bordereau(): BelongsTo
    {
        return $this->belongsTo(Bordereau::class , 'jour', 'date_attribution');
    }

    /**
     * Obtenir la collecte d'une attribution
     *
     * @return hasOne<Collecte>
     */
    public function collecte(): HasOne
    {
        return $this->hasOne(Collecte::class);
    }
}
