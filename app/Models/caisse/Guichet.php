<?php

namespace App\Models\caisse;

use App\Enums\StatusGuichet;
use App\Models\Architecture\Site;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStatus\HasStatuses;
use Illuminate\Database\Eloquent\Builder;

class Guichet extends Model
{
    use HasStatuses, SoftDeletes;

    protected $fillable = ['nom', 'code', 'site_id'];
    /**
     *
     * @var array<int, string>
     */
    protected $appends = ['status'];

    const RULES = [
        'nom' => 'required|max:255',
        'site_id' => 'required|numeric'
    ];

    public function codeGenerate(): void
    {
        $rang = $this->count() + 1;
        $this->attributes['code'] = GUICHET_CODE_PREFIXE . str_pad((string)$rang, 7, '0', STR_PAD_LEFT);
    }

    public function close(): void
    {
        $this->setStatus(StatusGuichet::CLOSE->value);
    }

    public function open(): void
    {
        $this->setStatus(StatusGuichet::OPEN->value);
    }

    // scopes

    /**
     * Obtenir les guichets fermés
     *
     * @param Builder<Guichet> $query
     * @return Builder<Guichet>
     */
    public function scopeClosed(Builder $query): Builder
    {
        return $query->currentStatus(StatusGuichet::CLOSE->value);
    }

    /**
     * Obtenir les guichets ouverts
     *
     * @param Builder<Guichet> $query
     * @return Builder<Guichet>
     */
    public function scopeOpened(Builder $query): Builder
    {
        return $query->currentStatus(StatusGuichet::OPEN->value);
    }

    /**
     * Obtenir les sites correspondant à un Guichet
     * @return BelongsTo<Site, Guichet>
     * @author Ahoussou Jean-Chris
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
