<?php

namespace App\Models\Caisse;

use App\Models\Architecture\Site;
use App\Models\Exploitation\Ordonnancement;
use App\Models\Scopes\OwnSiteScope;
use App\Models\Scopes\RecentScope;
use App\Traits\HasOwnerScope;
use App\Traits\HasResponsible;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as ContractAuditable;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasOneDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

/**
 * @mixin IdeHelperFermeture
 */
class Fermeture extends Model implements ContractAuditable
{
    use Auditable, HasRelationships, HasResponsible, HasOwnerScope;

    protected $fillable = ['code', 'ouverture_id', 'total'];
    protected $casts = ['total' => 'integer'];
    protected $dates = ['created_at'];

    const RULES = [
        'caissier_id' => 'required',
        'total' => 'required|gte:total_normal',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new RecentScope);
        static::addGlobalScope(new OwnSiteScope);
    }

    public function codeGenerate(): void
    {
        $rang = empty($this->latest()->first()) ? 1 : $this->latest()->first()->id;
        $this->attributes['code'] = FERMETURE_CODE_PREFIXE . str_pad((string) $rang, 5, '0', STR_PAD_LEFT) . Carbon::now()->format('y');
    }

    public function ouverture(): BelongsTo
    {
        return $this->belongsTo(Ouverture::class);
    }

    public function ordonnancement(): HasManyDeep
    {
        return $this->hasManyDeep(
            Ordonnancement::class,
            [Ouverture::class, Encaissement::class],
            ['id', 'ouverture_id', 'id'],
            ['ouverture_id', 'id', 'ordonnancement_id']
        );
    }

    public function site(): HasOneDeep
    {
        return $this->hasOneDeep(
            Site::class,
            [Ouverture::class, Guichet::class],
            ['id', 'id', 'id'],
            ['ouverture_id', 'guichet_id', 'site_id'],
        );
    }

    public function guichet(): HasOneThrough
    {
        return $this->hasOneThrough(Guichet::class, Ouverture::class, 'id', 'id', 'ouverture_id', 'guichet_id');
    }

    public function caissier(): HasOneThrough
    {
        return $this->hasOneThrough(Caissier::class, Ouverture::class, 'id', 'id', 'ouverture_id', 'caissier_id');
    }
}
