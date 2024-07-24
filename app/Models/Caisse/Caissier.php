<?php

namespace App\Models\Caisse;

use App\Models\Scopes\RecentScope;
use App\Models\User;
use App\Traits\HasOwnerScope;
use App\Traits\HasResponsible;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @mixin IdeHelperCaissier
 */
class Caissier extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use HasOwnerScope;
    use HasResponsible;

    protected $fillable = ['code', 'user_id'];
    protected $dates = ['created_at'];
    protected $auditExclude = ['code'];
    const RULES = ['user_id' => 'required|numeric'];

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
        $rang = $this->whereYear('created_at', Carbon::now()->format('Y'))->count() + 1;
        $this->attributes['code'] = config('constants.CAISSIER_CODE_PREFIXE') . str_pad((string) $rang, 5, '0', STR_PAD_LEFT) . Carbon::now()->format('y');
    }

    public function scopeFree(Builder $query): Builder
    {
        return $query->whereDoesntHave('ouvertures', fn (Builder $query): Builder => $query->checked())
            ->whereDoesntHave('ouvertures', fn (Builder $query): Builder => $query->using());
    }
    public function scopeBusy(Builder $query): Builder
    {
        return $query->whereHas('ouvertures', fn (Builder $query): Builder => $query->using());
    }

    public function scopeHalfFree($query): Builder
    {
        return $query->whereHas('ouvertures', fn (Builder $query): Builder => $query->checked());
    }

    /**
     * Obtenir l'utilisateur lié à un caissier
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ouvertures(): HasMany
    {
        return $this->hasMany(Ouverture::class);
    }

    /**
     * Obtenir les attributions de guichet d'un caissier
     */
    public function attributionsGuichet(): BelongsToMany
    {
        return $this->belongsToMany(Guichet::class, 'attribution_guichets', 'caissier_id', 'guichet_id')->withPivot('date', 'id')->withTimestamps();
    }
}
