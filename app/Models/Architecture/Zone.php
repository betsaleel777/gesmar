<?php

namespace App\Models\Architecture;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Staudenmeir\EloquentHasManyDeep\HasOneDeep;

/**
 * @mixin IdeHelperZone
 */
class Zone extends Model implements Auditable
{
    use SoftDeletes;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['nom', 'code', 'niveau_id'];
    protected $dates = ['created_at'];

    const RULES = [
        'nom' => 'required|max:150',
        'niveau_id' => 'required',
    ];
    /**
     *
     * @var array<int, string>
     */
    protected $with = ['niveau', 'pavillon', 'site'];
    /**
     *
     * @var array<int, string>
     */
    protected $appends = ['code'];

    const MIDDLE_RULES = [
        'niveau_id' => 'required',
        'nombre' => 'required|numeric|min:1',
    ];

    const PUSH_RULES = [
        'nombre' => 'required|numeric|min:1',
    ];

    /**
     *
     * @return Attribute<string, never>
     */
    protected function code(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->niveau->pavillon->code . $this->niveau->code . str_pad((string) $this->attributes['code'], 4, '0', STR_PAD_LEFT),
        );
    }

    /**
     * Obtenir le niveau d'une zone
     *
     * @return BelongsTo<Niveau, Zone>
     */
    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class);
    }

    /**
     * Obtenir les emplacement d'une zone
     *
     * @return HasMany<Emplacement>
     */
    public function emplacements(): HasMany
    {
        return $this->hasMany(Emplacement::class);
    }

    public function pavillon(): HasOneDeep
    {
        return $this->hasOneDeep(
            Pavillon::class,
            [Niveau::class],
            ['id', 'id'],
            ['niveau_id', 'pavillon_id'],
        );
    }

    public function site(): HasOneDeep
    {
        return $this->hasOneDeep(
            Site::class,
            [Niveau::class, Pavillon::class],
            ['id', 'id', 'id'],
            ['niveau_id', 'pavillon_id', 'site_id'],
        );
    }
}
