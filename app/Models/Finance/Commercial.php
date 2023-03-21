<?php

namespace App\Models\Finance;

use App\Models\Finance\Attribution;
use App\Models\User;
use App\Traits\HasSites;
use App\Traits\RecentOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperCommercial
 */
class Commercial extends Model
{
    use HasFactory, RecentOrder, HasSites, SoftDeletes;

    protected $fillable = ['code', 'user_id', 'site_id'];
    /**
     *
     * @var array<int, string>
     */
    protected $with = ['user', 'site'];
    const RULES = [
        'user_id' => 'required|numeric',
        'site_id' => 'required|numeric',
    ];

    const ATTRIBUTION_RULES = [
        'jour' => 'required',
        'zones' => 'required',
    ];

    public function codeGenerate(): void
    {
        $rang = $this->count() + 1;
        $this->attributes['code'] = COMMERCIAL_CODE_PREFIXE . str_pad((string) $rang, 7, '0', STR_PAD_LEFT);
    }

    /**
     * Obtenir l'utilisateur lié à un commercial
     *
     * @return BelongsTo<User, Commercial>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir les emplacements attribués à un commercial
     *
     * @return HasMany<Attribution>
     */
    public function attributions(): HasMany
    {
        return $this->hasMany(Attribution::class);
    }

    /**
     * Obtenir les bordereaux d'un commercial
     *
     * @return HasMany<Bordereau>
     */
    public function bordereaux(): HasMany
    {
        return $this->HasMany(Bordereau::class);
    }
}
