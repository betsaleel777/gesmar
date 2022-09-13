<?php

namespace App\Models\Architecture;

use App\Enums\StatusValidationAbonnement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\ModelStatus\HasStatuses;

class ValidationAbonnement extends Model
{
    use HasFactory;
    use HasStatuses;

    protected $fillable = ['raison', 'abonnement_id'];
    /**
     *
     * @var array<int, string>
     */
    protected $appends = ['status'];
    /**
     *
     * @var array<int, string>
     */
    protected $with = ['statuses'];

    public const RULES = ['raison' => 'required', 'abonnement_id' => 'required'];

    public function confirmer(): void
    {
        $this->setStatus(StatusValidationAbonnement::VALIDATED->value);
    }

    public function rejeter(): void
    {
        $this->setStatus(StatusValidationAbonnement::UNVALIDATED->value);
    }

    /**
     * Obtenir les validations confirmées
     *
     * @param Builder<ValidationAbonnement> $query
     * @return Builder<ValidationAbonnement>
     */
    public function scopeConfirmed(Builder $query): Builder
    {
        return $query->currentStatus(StatusValidationAbonnement::VALIDATED->value);
    }

    /**
     * Obtenir les validations rejétées
     *
     * @param Builder<ValidationAbonnement> $query
     * @return Builder<ValidationAbonnement>
     */
    public function scopeRejected(Builder $query): Builder
    {
        return $query->currentStatus(StatusValidationAbonnement::UNVALIDATED->value);
    }

    /**
     * Obtenir l'abonnement lié à la validation
     *
     * @return BelongsTo<Abonnement, ValidationAbonnement>
     */
    public function abonnement(): BelongsTo
    {
        return $this->belongsTo(Abonnement::class);
    }
}
