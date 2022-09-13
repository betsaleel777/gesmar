<?php

namespace App\Models\Architecture;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperTypeEmplacement
 */
class TypeEmplacement extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['nom', 'site_id', 'prefix', 'code', 'auto_valid', 'equipable'];

    /**
     * les propriétés qui doivent être caster.
     *
     * @var array<string, string>
     */
    protected $casts = ['equipable' => 'boolean', 'auto_valid' => 'boolean'];

    /**
     *
     * @var array<int, string>
     */
    protected $appends = ['code'];

    public const RULES = [
        'nom' => 'required|max:150',
        'site_id' => 'required',
        'prefix' => 'required|max:5|min:2|alpha',
    ];

    /**
     *
     * @return Attribute<string, never>
     */
    protected function code(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->attributes['prefix'] . str_pad((string) $this->attributes['code'], 2, '0', STR_PAD_LEFT),
        );
    }

    /**
     * Undocumented function
     *
     * @param  Builder<TypeEmplacement>  $query
     * @return Builder<TypeEmplacement>
     */
    public function scopeEquipables(Builder $query): Builder
    {
        return $query->where('equipable', true);
    }

    /**
     * Undocumented function
     *
     * @return HasMany<Emplacement>
     */
    public function emplacements(): HasMany
    {
        return $this->hasMany(Emplacement::class, 'type_emplacement_id');
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo<Site, TypeEmplacement>
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
