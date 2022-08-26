<?php

namespace App\Models\Architecture;

use App\Enums\ModeServiceAnnexe;
use App\Models\Exploitation\Contrat;
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

    public const RULES = [
        'nom' => 'required|max:250',
        'prix' => 'required',
        'site_id' => 'required',
        'mode' => 'required',
    ];

    public function forfaitaire(): void
    {
        $this->attributes['mode'] = ModeServiceAnnexe::FORFAIT;
    }

    public function quotidien(): void
    {
        $this->attributes['mode'] = ModeServiceAnnexe::QUOTIDIEN;
    }

    public function mensuel(): void
    {
        $this->attributes['mode'] = ModeServiceAnnexe::MENSUEL;
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo<Site, ServiceAnnexe>
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * Undocumented function
     *
     * @return HasMany<Contrat>
     */
    public function contrats(): HasMany
    {
        return $this->hasMany(Contrat::class);
    }
}
