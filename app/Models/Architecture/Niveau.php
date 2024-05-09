<?php

namespace App\Models\Architecture;

use App\Models\Scopes\OwnSiteScope;
use App\Models\Scopes\RecentScope;
use App\Traits\HasOwnerScope;
use App\Traits\HasResponsible;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Staudenmeir\EloquentHasManyDeep\HasOneDeep;

/**
 * @mixin IdeHelperNiveau
 */
class Niveau extends Model implements Auditable
{
    use SoftDeletes;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;
    use \OwenIt\Auditing\Auditable;
    use HasResponsible;
    use HasOwnerScope;

    protected $fillable = ['nom', 'code', 'pavillon_id'];
    const RULES = [
        'nom' => 'required|max:150',
        'pavillon_id' => 'required',
    ];

    const MIDDLE_RULES = [
        'pavillon_id' => 'required',
        'nombre' => 'required|numeric|min:1',
    ];

    const PUSH_RULES = [
        'nombre' => 'required|numeric|min:1',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new RecentScope);
        static::addGlobalScope(new OwnSiteScope);
    }

    public function pavillon(): BelongsTo
    {
        return $this->belongsTo(Pavillon::class);
    }

    public function site(): HasOneDeep
    {
        return $this->hasOneDeep(
            Site::class,
            [Pavillon::class],
            ['id', 'id'],
            ['pavillon_id', 'site_id'],
        );
    }

    public function zones(): HasMany
    {
        return $this->hasMany(Zone::class);
    }
}
