<?php

namespace App\Models\Bordereau;

use App\Models\Scopes\OwnSiteScope;
use App\Models\Scopes\RecentScope;
use App\Models\User;
use App\Traits\HasSites;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    protected $dates = ['created_at'];
    const RULES = [
        'user_id' => 'required|numeric',
        'site_id' => 'required|numeric',
    ];

    const ATTRIBUTION_RULES = ['jour' => 'required', 'zones' => 'required'];

    protected static function booted(): void
    {
        static::addGlobalScope(new RecentScope);
        static::addGlobalScope(new OwnSiteScope);
    }

    public function codeGenerate(): void
    {
        $rang = empty($this->orderBy('id', 'desc')->first()) ? 1 : $this->orderBy('id', 'desc')->first()->id + 1;
        $this->attributes['code'] = config('constants.COMMERCIAL_CODE_PREFIXE') . str_pad((string) $rang, 7, '0', STR_PAD_LEFT);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bordereaux(): HasMany
    {
        return $this->hasMany(Bordereau::class);
    }
}
