<?php

namespace App\Models\Bordereau;

use App\Models\Scopes\RecentScope;
use App\Models\User;
use App\Traits\HasSites;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @mixin IdeHelperCommercial
 */
class Commercial extends Model implements Auditable
{
    use HasSites, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['code', 'user_id', 'site_id'];
    protected $auditExclude = ['code'];
    /**
     *
     * @var array<int, string>
     */
    const RULES = [
        'user_id' => 'required|numeric',
        'site_id' => 'required|numeric',
    ];

    const ATTRIBUTION_RULES = [
        'jour' => 'required',
        'zones' => 'required',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new RecentScope);
    }

    public function codeGenerate(): void
    {
        $rang = $this->count() + 1;
        $this->attributes['code'] = COMMERCIAL_CODE_PREFIXE . str_pad((string) $rang, 7, '0', STR_PAD_LEFT);
    }

    /**
     * Obtenir l'utilisateur lié à un commercial
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir les bordereaux d'un commercial
     */
    public function bordereaux(): BelongsToMany
    {
        return $this->belongsToMany(Bordereau::class, 'bordereau_emplacement', 'commercial_id', 'bordereau_id');
    }
}
