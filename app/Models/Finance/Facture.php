<?php

namespace App\Models\Finance;

use App\Enums\StatusFacture;
use App\Models\Architecture\Emplacement;
use App\Models\Architecture\ServiceAnnexe;
use App\Models\Exploitation\Contrat;
use App\Models\Exploitation\Paiement;
use App\Models\Scopes\RecentScope;
use App\Traits\HasEquipement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\ModelStatus\HasStatuses;

/**
 * @mixin IdeHelperFacture
 */
class Facture extends Model implements Auditable
{
    use HasFactory;
    use HasStatuses;
    use HasEquipement;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'code',
        'contrat_id',
        'annexe_id',
        'index_depart',
        'index_fin',
        'equipement_id',
        'avance',
        'caution',
        'pas_porte',
        'periode',
    ];
    protected $auditExclude = ['code'];

    protected $with = ['contrat'];

    protected $appends = ['status'];

    protected $casts = [
        'avance' => 'integer', 'caution' => 'integer', 'index_fin' => 'integer',
        'pas_porte' => 'integer', 'index_depart' => 'integer', 'contrat_id' => 'integer',
        'equipement_id' => 'integer', 'annexe_id' => 'integer',
    ];

    public const RULES = [
        'contrat_id' => 'required',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new RecentScope);
    }

    public function codeGenerate(string $prefix): void
    {
        $rang = $this->count() + 1;
        $this->attributes['code'] = $prefix . str_pad((string) $rang, 7, '0', STR_PAD_LEFT);
    }

    /**
     * règles du formulaire de création d'une facture initiale
     */
    public static function initialeRules(): array
    {
        return [
             ...self::RULES, ...[
                'avance' => 'required|numeric',
                'caution' => 'required|numeric',
                'pas_porte' => 'required|numeric',
            ],
        ];
    }

    const INITIALE_EDIT_RULES = [
        'avance' => 'required|numeric',
        'caution' => 'required|numeric',
        'pas_porte' => 'required|numeric',
    ];

    /**
     * règles du formulaire de création d'une facture d'équipement
     */
    public static function gearRules(): array
    {
        return [
             ...self::RULES, ...[
                'equipement_id' => 'required|numeric',
                'index_depart' => 'required|numeric',
                'index_fin' => 'required|numeric',
            ],
        ];
    }

    /**
     * règles du formulaire de création d'une facture de loyer (bail)
     */
    public static function loyerRules(): array
    {
        return [ ...self::RULES, ...['periode' => 'required']];
    }

    public function payer(): void
    {
        $this->setStatus(StatusFacture::PAID->value);
    }

    public function facturable(): void
    {
        $this->setStatus(StatusFacture::FACTURE->value);
    }

    public function proforma(): void
    {
        $this->setStatus(StatusFacture::PROFORMA->value);
    }

    public function isAnnexe(): bool
    {
        return Str::substr($this->attributes['code'], 0, 3) === ANNEXE_FACTURE_PREFIXE;
    }

    public function isEquipement(): bool
    {
        return Str::substr($this->attributes['code'], 0, 3) === EQUIPEMENT_FACTURE_PREFIXE;
    }

    public function isInitiale(): bool
    {
        return Str::substr($this->attributes['code'], 0, 3) === INITIALE_FACTURE_PREFIXE;
    }

    public function isLoyer(): bool
    {
        return Str::substr($this->attributes['code'], 0, 3) === LOYER_FACTURE_PREFIXE;
    }

    // scopes

    /**
     * Obtenir les facture de service annexes
     */
    public function scopeIsAnnexe(Builder $query): Builder
    {
        return $query->whereNotNull('annexe_id');
    }

    /**
     * Obtenir les factures d'équipement
     */
    public function scopeIsEquipement(Builder $query): Builder
    {
        return $query->whereNotNull('equipement_id');
    }

    /**
     * Obtenir les factures initiales
     */
    public function scopeIsInitiale(Builder $query): Builder
    {
        return $query->whereNull('annexe_id')->whereNull('periode')->whereNull('equipement_id');
    }

    /**
     * Obtenir les factures de loyer
     */
    public function scopeIsLoyer(Builder $query): Builder
    {
        return $query->whereNotNull('periode')->whereNull('equipement_id');
    }

    /**
     * Obtenir les prospects
     */
    public function scopeIsPaid(Builder $query): Builder
    {
        return $query->currentStatus(StatusFacture::PAID->value);
    }

    /**
     * Obtenir les factures payées partielements ou impayées
     */
    public function scopeIsUnpaid(Builder $query): Builder
    {
        return $query->otherCurrentStatus(StatusFacture::PAID->value);
    }

    /**
     * Obtenir les proformas
     */
    public function scopeIsProforma(Builder $query): Builder
    {
        return $query->currentStatus(StatusFacture::PROFORMA->value);
    }

    /**
     * Obtenir les factures
     */
    public function scopeIsFacture(Builder $query): Builder
    {
        return $query->currentStatus(StatusFacture::FACTURE->value);
    }

    /**
     * Obtenir les factures pour les emplacement avec paiement de loyer mensuel à l'ordonnancement
     */
    public function scopeIsSuperMarket(Builder $query): Builder
    {
        return $query->whereHas('contrat', fn(Builder $query) => $query->where('auto_valid', false));
    }

    // relations

    /**
     * Undocumented function
     */
    public function annexe(): BelongsTo
    {
        return $this->belongsTo(ServiceAnnexe::class);
    }

    /**
     * Undocumented function
     */
    public function contrat(): BelongsTo
    {
        return $this->belongsTo(Contrat::class);
    }

    /**
     * Obtenir les paiements d'une facture
     */
    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class);
    }
}
