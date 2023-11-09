<?php

namespace App\Models\Architecture;

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

    const MIDDLE_RULES = [
        'niveau_id' => 'required',
        'nombre' => 'required|numeric|min:1',
    ];

    const PUSH_RULES = [
        'nombre' => 'required|numeric|min:1',
    ];

    public function getCode(): ?string
    {
        $this->loadMissing('niveau:niveaux.id,niveaux.code', 'pavillon:pavillons.id,pavillons.code');
        return $this->pavillon?->code . $this->niveau?->code . str((string) $this->code)->padLeft(4, '0');
    }

    /**
     * Obtenir le niveau d'une zone
     */
    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class);
    }

    /**
     * Obtenir les emplacement d'une zone
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
