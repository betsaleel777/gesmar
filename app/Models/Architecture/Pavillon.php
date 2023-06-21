<?php

namespace App\Models\Architecture;

use App\Traits\HasSites;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperPavillon
 */
class Pavillon extends Model
{
    use SoftDeletes, HasSites;

    protected $fillable = ['nom', 'code', 'site_id'];
    protected $dates = ['created_at'];
    /**
     *
     * @var array<int, string>
     */
    protected $appends = ['code'];

    const RULES = [
        'nom' => 'required|max:150',
        'site_id' => 'required',
    ];

    const MIDDLE_RULES = [
        'site_id' => 'required',
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
            get: fn () => str_pad((string) $this->attributes['code'], 2, '0', STR_PAD_LEFT),
        );
    }

    /**
     * Undocumented function
     *
     * @return HasMany<Niveau>
     */
    public function niveaux(): HasMany
    {
        return $this->hasMany(Niveau::class);
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
