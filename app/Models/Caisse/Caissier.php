<?php

namespace App\Models\Caisse;

use App\Models\Scopes\RecentScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperCaissier
 */
class Caissier extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'user_id'];
    protected $dates = ['created_at'];
    /**
     *
     * @var array<int, string>
     */
    protected $with = ['user'];
    const RULES = [
        'user_id' => 'required|numeric',
    ];

    const ATTRIBUTION_RULES = [
        'dates' => 'required',
        'guichet_id' => 'required|numeric',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new RecentScope);
    }

    public function codeGenerate(): void
    {
        $rang = $this->count() + 1;
        $this->attributes['code'] = CAISSIER_CODE_PREFIXE . str_pad((string) $rang, 7, '0', STR_PAD_LEFT);
    }

    /**
     * Obtenir l'utilisateur lié à un caissier
     *
     * @return BelongsTo<User, Caissier>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir les attributions de guichet d'un caissier
     *
     * @return BelongsToMany<Guichet>
     */
    public function attributions(): BelongsToMany
    {
        return $this->belongsToMany(Guichet::class, 'attribution_guichets', 'caissier_id', 'guichet_id')->withPivot('date', 'id')->withTimestamps();
    }
}
