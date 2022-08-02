<?php

namespace App\Models\Finance;

use App\Models\Architecture\Equipement;
use App\Models\Architecture\ServiceAnnexe;
use App\Models\Exploitation\Contrat;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperFacture
 */
class Facture extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'contrat_id', 'date_soldee', 'annexe_id', 'date_facture', 'index_debut', 'index_fin',
        'equipement_id', 'avance', 'caution', 'pas_porte', 'date_plan', 'periode',
    ];

    protected $appends = ['status'];

    private const PAID = 'payée';

    private const UNPAID = 'impayée';

    const SHEDULABLE = 'planifiable';

    const RULES = [
        'contrat_id' => 'required',
    ];

    /**
     * Undocumented function
     *
     * @return Attribute{get:(callable(): string)}
     */
    protected function status(): Attribute
    {
        return new Attribute(
            get:function () {
                if ($this->attributes['date_plan']) {
                    return self::SHEDULABLE;
                } elseif ($this->attributes['date_soldee']) {
                    return self::PAID;
                } else {
                    return self::UNPAID;
                }
            },
        );
    }

    public function codeGenerate(string $prefix): void
    {
        $rang = $this->get()->count() + 1;
        $this->attributes['code'] = $prefix . str_pad((string) $rang, 7, '0', STR_PAD_LEFT);
    }

    public static function initialeRules(): array
    {
        return array_merge(self::RULES, [
            'avance' => 'required|numeric',
            'caution' => 'required|numeric',
            'pas_porte' => 'required|numeric',
        ]);
    }

    public static function gearRules(): array
    {
        return array_merge(self::RULES, [
            'equipement_id' => 'required|numeric',
            'index_debut' => 'required|numeric',
            'index_fin' => 'required|numeric',
        ]);
    }

    public static function loyerRules(): array
    {
        return array_merge(self::RULES, ['periode' => 'required']);
    }

    public function payer(): void
    {
        $this->attributes['date_soldee'] = Carbon::now();
    }

    public function planifier(): void
    {
        $this->attributes['date_plan'] = Carbon::now();
    }

    // scopes

    /**
     * Undocumented function
     *
     * @param Builder<Facture> $query
     * @return Builder<Facture>
     */
    public function scopeSoldees(Builder $query): Builder
    {
        return $query->whereNotNull('date_soldee');
    }

    /**
     * Undocumented function
     *
     * @param Builder<Facture> $query
     * @return Builder<Facture>
     */
    public function scopeValidees(Builder $query): Builder
    {
        return $query->whereNotNull('date_facture');
    }

    /**
     * Undocumented function
     *
     * @param Builder<Facture> $query
     * @return Builder<Facture>
     */
    public function scopeNonValidees(Builder $query): Builder
    {
        return $query->whereNull('date_facture');
    }

    /**
     * Undocumented function
     *
     * @param Builder<Facture> $query
     * @return Builder<Facture>
     */
    public function scopeIsAnnexe(Builder $query): Builder
    {
        return $query->whereNotNull('annexe_id');
    }

    /**
     * Undocumented function
     *
     * @param Builder<Facture> $query
     * @return Builder<Facture>
     */
    public function scopeIsEquipement(Builder $query): Builder
    {
        return $query->whereNotNull('equipement_id');
    }

    /**
     * Undocumented function
     *
     * @param Builder<Facture> $query
     * @return Builder<Facture>
     */
    public function scopeIsInitiale(Builder $query): Builder
    {
        return $query->whereNull('annexe_id')->whereNull('periode')->whereNull('equipement_id');
    }

    /**
     * Undocumented function
     *
     * @param Builder<Facture> $query
     * @return Builder<Facture>
     */
    public function scopeIsLoyer(Builder $query): Builder
    {
        return $query->whereNotNull('periode')->whereNull('equipement_id');
    }

    // relations
    /**
     * Undocumented function
     *
     * @return BelongsTo<ServiceAnnexe>
     */
    public function annexe(): BelongsTo
    {
        return $this->belongsTo(ServiceAnnexe::class);
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo<Equipement>
     */
    public function equipement(): BelongsTo
    {
        return $this->belongsTo(Equipement::class);
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo<Contrat>
     */
    public function contrat(): BelongsTo
    {
        return $this->belongsTo(Contrat::class);
    }

    /**
     * Undocumented function
     *
     * @return HasMany<int, Collection<int, Versement>>
     */
    public function versements(): HasMany
    {
        return $this->hasMany(Versement::class);
    }
}
