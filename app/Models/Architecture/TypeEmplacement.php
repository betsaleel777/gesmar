<?php

namespace App\Models\Architecture;

use App\Models\Scopes\OwnSiteScope;
use App\Models\Scopes\RecentScope;
use App\Traits\HasOwnerScope;
use App\Traits\HasResponsible;
use App\Traits\HasSites;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @mixin IdeHelperTypeEmplacement
 */
class TypeEmplacement extends Model implements Auditable
{
    use HasFactory, HasSites, HasResponsible, HasOwnerScope, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['nom', 'site_id', 'prefix', 'auto_valid', 'frais_dossier', 'frais_amenagement', 'equipable'];
    protected $dates = ['created_at'];

    protected $casts = [
        'equipable' => 'boolean',
        'auto_valid' => 'boolean',
        'frais_dossier' => 'integer',
        'frais_amenagement' => 'integer',
    ];

    public const RULES = [
        'nom' => 'required|max:150',
        'site_id' => 'required',
        'frais_dossier' => 'required|numeric',
        'frais_amenagement' => 'required|numeric',
        'prefix' => 'required|max:5|min:2|alpha',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new RecentScope);
        static::addGlobalScope(new OwnSiteScope);
    }

    public function getCode(): string
    {
        return !empty($this->prefix) and !empty($this->code) ? $this->prefix . str((string) $this->attributes['code'])->padLeft(2, '0') : null;
    }

    public function scopeEquipables(Builder $query): Builder
    {
        return $query->where('equipable', true);
    }

    public function emplacements(): HasMany
    {
        return $this->hasMany(Emplacement::class, 'type_emplacement_id');
    }
}
