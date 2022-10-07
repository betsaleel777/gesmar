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

    protected $fillable = ['code', 'nom', 'site_id', 'prix', 'description', 'mode'];

    public const RULES = [
        'nom' => 'required|max:250',
        'prix' => 'required',
        'site_id' => 'required',
        'mode' => 'required',
    ];

    public function codeGenerate(): void
    {
        $rang = $this->count() + 1;
        $this->attributes['code'] = ANNEXE_CODE_PREFIXE . str_pad((string) $rang, 7, '0', STR_PAD_LEFT);
    }

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
     * Obtenir le site d'un service annexe
     *
     * @return BelongsTo<Site, ServiceAnnexe>
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * Obtenir les contrats d'un service annexe
     *
     * @return HasMany<Contrat>
     */
    public function contrats(): HasMany
    {
        return $this->hasMany(Contrat::class);
    }
}
