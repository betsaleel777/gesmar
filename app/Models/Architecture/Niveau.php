<?php

namespace App\Models\Architecture;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentHasManyDeep\HasOneDeep;

/**
 * @mixin IdeHelperNiveau
 */
class Niveau extends Model
{
    use SoftDeletes;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

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

    /**
     * Undocumented function
     *
     * @return BelongsTo<Pavillon, Niveau>
     */
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

    /**
     * Undocumented function
     *
     * @return HasMany<Zone>
     */
    public function zones(): HasMany
    {
        return $this->hasMany(Zone::class);
    }
}
