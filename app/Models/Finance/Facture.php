<?php

namespace App\Models\Finance;

use App\Enums\StatusFacture;
use App\Models\Architecture\Equipement;
use App\Models\Architecture\ServiceAnnexe;
use App\Models\Architecture\Site;
use App\Models\Exploitation\Contrat;
use App\Models\Exploitation\Paiement;
use App\Models\Exploitation\Personne;
use App\Models\Scopes\OwnSiteScope;
use App\Models\Scopes\RecentScope;
use App\Traits\HasEquipement;
use App\Traits\HasOwnerScope;
use App\Traits\HasResponsible;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\ModelStatus\HasStatuses;

/**
 * @mixin IdeHelperFacture
 */
class Facture extends Model implements Auditable
{
    use HasStatuses;
    use HasEquipement;
    use \OwenIt\Auditing\Auditable;
    use HasResponsible;
    use HasOwnerScope;

    // TODO: ajouter ici les propriété en migration (avec requete de mise au point) de l'équipement pour prevenir les modification (prix_fixe,frais_facture,date_limite)
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
        'montant_annexe',
        'montant_loyer',
        'montant_equipement',
        'prix_fixe',
        'frais_facture',
        'frais_dossier',
        'frais_amenagement',
        'date_limite',
    ];
    protected $auditExclude = ['code'];
    protected $appends = ['status'];

    protected $casts = [
        'avance' => 'integer',
        'caution' => 'integer',
        'index_fin' => 'integer',
        'pas_porte' => 'integer',
        'index_depart' => 'integer',
        'contrat_id' => 'integer',
        'equipement_id' => 'integer',
        'annexe_id' => 'integer',
        'frais_dossier' => 'integer',
        'frais_amenagement' => 'integer',
        'montant_loyer' => 'integer',
        'montant_equipement' => 'integer',
        'prix_fixe' => 'integer',
        'frais_facture' => 'integer',
        'date_limite' => 'date'
    ];

    public const RULES = ['contrat_id' => 'required'];

    protected static function booted(): void
    {
        static::addGlobalScope(new RecentScope);
        static::addGlobalScope(new OwnSiteScope);
    }

    public function codeGenerate(string $prefix): void
    {
        $rang = empty($this->orderBy('id', 'desc')->first()) ? 1 : $this->orderBy('id', 'desc')->first()->id + 1;
        $this->attributes['code'] = $prefix . str_pad((string) $rang, 5, '0', STR_PAD_LEFT) . Carbon::now()->format('y');
    }

    /**
     * règles du formulaire de création d'une facture initiale
     */
    public static function initialeRules(): array
    {
        return [
            ...self::RULES,
            ...[
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
            ...self::RULES,
            ...[
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
        return [...self::RULES, ...['periode' => 'required']];
    }

    public function getFactureInitialeTotalAmount(): int
    {
        return (int) $this?->pas_porte + (int) $this?->caution + (int) $this?->avance + (int) $this?->frais_dossier +
            (int) $this?->frais_amenagement;
    }

    public function getEquipementTotalAmount(): int
    {
        return ((int)$this?->index_fin - (int)$this?->index_depart) * (int)$this->montant_equipement + (int)$this?->prix_fixe + (int)$this->frais_facture;
    }

    public function getType(): string
    {
        return match (true) {
            boolval($this->annexe_id) => 'annexe',
            boolval($this->equipement_id) => 'equipement',
            boolval($this->periode) => 'loyer',
            default => 'initiale'
        };
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
        return Str::substr($this->attributes['code'], 0, 3) === config('constants.ANNEXE_FACTURE_PREFIXE');
    }

    public function isEquipement(): bool
    {
        return Str::substr($this->attributes['code'], 0, 3) === config('constants.EQUIPEMENT_FACTURE_PREFIXE');
    }

    public function isInitiale(): bool
    {
        return Str::substr($this->attributes['code'], 0, 3) === config('constants.INITIALE_FACTURE_PREFIXE');
    }

    public function isLoyer(): bool
    {
        return Str::substr($this->attributes['code'], 0, 3) === config('constants.LOYER_FACTURE_PREFIXE');
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
    /**
     * Obtenir les factures d'un client donné
     */
    public function scopeByPersonne(Builder $query, int $id): Builder
    {
        return $query->whereHas('contrat', fn(Builder $query) => $query->where('personne_id', $id));
    }

    public function scopeWithUnpaidAmount(Builder $query, int $id): Builder
    {
        $facture = self::find($id);
        return $query->addSelect([
            'impayes' => self::query()->selectRaw('SUM((index_fin-index_depart)*montant_equipement+prix_fixe+frais_facture)')
                ->whereDate('periode', '<', $facture->periode)->where('contrat_id', $facture->contrat_id)
        ])->isEquipement();
    }

    // relations

    public function annexe(): BelongsTo
    {
        return $this->belongsTo(ServiceAnnexe::class);
    }

    public function contrat(): BelongsTo
    {
        return $this->belongsTo(Contrat::class);
    }

    public function equipement(): BelongsTo
    {
        return $this->belongsTo(Equipement::class);
    }

    /**
     * Obtenir les paiements d'une facture
     */
    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class);
    }

    public function site(): HasOneThrough
    {
        return $this->hasOneThrough(Site::class, Contrat::class, 'id', 'id', 'contrat_id', 'site_id');
    }

    public function personne(): HasOneThrough
    {
        return $this->hasOneThrough(Personne::class, Contrat::class, 'id', 'id', 'contrat_id', 'personne_id');
    }
}
