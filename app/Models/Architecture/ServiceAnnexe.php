<?php

namespace App\Models\Architecture;

use App\Models\Exploitation\Contrat;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperServiceAnnexe
 */
class ServiceAnnexe extends Model
{
    use SoftDeletes;

    protected $fillable = ['nom', 'site_id', 'prix', 'description', 'mode'];

    const RULES = [
        'nom' => 'required|max:250',
        'prix' => 'required',
        'site_id' => 'required',
        'mode' => 'required',
    ];

    const MENSUEL = 'par mois';

    const QUOTIDIEN = 'par jour';

    const FORFAIT = 'forfaitaire';

    public function forfaitaire(): void
    {
        $this->attributes['mode'] = self::FORFAIT;
    }

    public function quotidien(): void
    {
        $this->attributes['mode'] = self::QUOTIDIEN;
    }

    public function mensuel(): void
    {
        $this->attributes['mode'] = self::MENSUEL;
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo<Site>
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * Undocumented function
     *
     * @return HasMany<int, Collection<int, Contrat>>
     */
    public function contrats(): HasMany
    {
        return $this->hasMany(Contrat::class);
    }
}
