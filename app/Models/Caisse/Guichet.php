<?php

namespace App\Models\Caisse;

use App\Enums\StatusGuichet;
use App\Traits\HasSites;
use App\Traits\RecentOrder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStatus\HasStatuses;

/**
 * @mixin IdeHelperGuichet
 */
class Guichet extends Model
{
    use HasStatuses, HasSites, RecentOrder, SoftDeletes;

    protected $fillable = ['nom', 'code', 'site_id'];
    /**
     *
     * @var array<int, string>
     */
    protected $appends = ['status'];

    const RULES = [
        'nom' => 'required|max:255',
        'site_id' => 'required|numeric',
    ];

    public function codeGenerate(): void
    {
        $rang = $this->count() + 1;
        $this->attributes['code'] = GUICHET_CODE_PREFIXE . str_pad((string) $rang, 7, '0', STR_PAD_LEFT);
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
}
