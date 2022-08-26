<?php

namespace App\Models\Finance;

use App\Enums\StatusFacture;
use App\Models\Architecture\Equipement;
use App\Models\Architecture\ServiceAnnexe;
use App\Models\Exploitation\Contrat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\ModelStatus\HasStatuses;

/**
 * @mixin IdeHelperFacture
 */
class Facture extends Model
{
    use HasFactory;
    use HasStatuses;

    protected $fillable = [
        'code', 'contrat_id', 'annexe_id', 'index_debut', 'index_fin', 'equipement_id', 'avance', 'caution', 'pas_porte', 'periode',
    ];

    public const RULES = [
        'contrat_id' => 'required',
    ];

    public function codeGenerate(string $prefix): void
    {
        $rang = $this->get()->count() + 1;
        $this->attributes['code'] = $prefix . str_pad((string) $rang, 7, '0', STR_PAD_LEFT);
    }

    /**
     * règles du formulaire de création d'une facture initiale
     *
     * @return array<string, string>
     */
    public static function initialeRules(): array
    {
        return array_merge(self::RULES, [
            'avance' => 'required|numeric',
            'caution' => 'required|numeric',
            'pas_porte' => 'required|numeric',
        ]);
    }

    /**
     * règles du formulaire de création d'une facture d'équipement
     *
     * @return array<string, string>
     */
    public static function gearRules(): array
    {
        return array_merge(self::RULES, [
            'equipement_id' => 'required|numeric',
            'index_debut' => 'required|numeric',
            'index_fin' => 'required|numeric',
        ]);
    }

    /**
     * règles du formulaire de création d'une facture de loyer (bail)
     *
     * @return array<string, string>
     */
    public static function loyerRules(): array
    {
        return array_merge(self::RULES, ['periode' => 'required']);
    }

    public function payer(): void
    {
        $this->setStatus(StatusFacture::PAID->value);
    }

    public function impayer(): void
    {
        $this->setStatus(StatusFacture::UNPAID->value);
    }

    public function facturable(): void
    {
        $this->setStatus(StatusFacture::FACTURE->value);
    }

    public function proforma(): void
    {
        $this->setStatus(StatusFacture::PROFORMA->value);
    }

    // scopes
    /**
     * Undocumented function
     *
     * @param  Builder<Facture>  $query
     * @return Builder<Facture>
     */
    public function scopeIsAnnexe(Builder $query): Builder
    {
        return $query->whereNotNull('annexe_id');
    }

    /**
     * Undocumented function
     *
     * @param  Builder<Facture>  $query
     * @return Builder<Facture>
     */
    public function scopeIsEquipement(Builder $query): Builder
    {
        return $query->whereNotNull('equipement_id');
    }

    /**
     * Undocumented function
     *
     * @param  Builder<Facture>  $query
     * @return Builder<Facture>
     */
    public function scopeIsInitiale(Builder $query): Builder
    {
        return $query->whereNull('annexe_id')->whereNull('periode')->whereNull('equipement_id');
    }

    /**
     * Undocumented function
     *
     * @param  Builder<Facture>  $query
     * @return Builder<Facture>
     */
    public function scopeIsLoyer(Builder $query): Builder
    {
        return $query->whereNotNull('periode')->whereNull('equipement_id');
    }

    /**
    * obtenir les prospects
    *
    * @param Builder<Facture> $query
    * @return Builder<Facture>
    */
    public function scopeIsPaid(Builder $query): Builder
    {
        return $query->currentStatus(StatusFacture::PAID->value);
    }

    /**
    * obtenir les factures payées partielements ou impayées
    *
    * @param Builder<Facture> $query
    * @return Builder<Facture>
    */
    public function scopeIsUnpaid(Builder $query): Builder
    {
        return $query->currentStatus(StatusFacture::UNPAID->value);
    }

    /**
    * obtenir les proformas
    *
    * @param Builder<Facture> $query
    * @return Builder<Facture>
    */
    public function scopeIsProforma(Builder $query): Builder
    {
        return $query->currentStatus(StatusFacture::PROFORMA->value);
    }

    /**
    * obtenir les factures
    *
    * @param Builder<Facture> $query
    * @return Builder<Facture>
    */
    public function scopeIsFacture(Builder $query): Builder
    {
        return $query->currentStatus(StatusFacture::FACTURE->value);
    }

    // relations

    /**
     * Undocumented function
     *
     * @return BelongsTo<ServiceAnnexe, Facture>
     */
    public function annexe(): BelongsTo
    {
        return $this->belongsTo(ServiceAnnexe::class);
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo<Equipement, Facture>
     */
    public function equipement(): BelongsTo
    {
        return $this->belongsTo(Equipement::class);
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo<Contrat, Facture>
     */
    public function contrat(): BelongsTo
    {
        return $this->belongsTo(Contrat::class);
    }

    /**
     * Undocumented function
     *
     * @return HasMany<Versement>
     */
    public function versements(): HasMany
    {
        return $this->hasMany(Versement::class);
    }
}
