<?php

namespace App\Models\Architecture;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperZone
 */
class Zone extends Model
{
    use SoftDeletes;

    protected $fillable = ['nom', 'code', 'niveau_id'];

    protected $appends = ['code'];

    const RULES = [
        'nom' => 'required|max:150',
        'niveau_id' => 'required',
    ];

    const MIDDLE_RULES = [
        'niveau_id' => 'required',
        'nombre' => 'required|numeric|min:1',
    ];

    const PUSH_RULES = [
        'nombre' => 'required|numeric|min:1',
    ];

    /**
     * Undocumented function
     *
     * @return Attribute{get:(callable(): string)}
     */
    protected function code(): Attribute
    {
        return new Attribute(
            get:fn() => str_pad((string) $this->attributes['code'], 4, '0', STR_PAD_LEFT),
        );
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo<Niveau>
     */
    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class);
    }

    /**
     * Undocumented function
     *
     * @return HasMany<int, Collection<int, Emplacement>>
     */
    public function emplacements(): HasMany
    {
        return $this->hasMany(Emplacement::class);
    }
}
