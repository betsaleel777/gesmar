<?php

namespace App\Models\Architecture;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperNiveau
 */
class Niveau extends Model
{
    use SoftDeletes;

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
