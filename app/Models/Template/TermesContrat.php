<?php

namespace App\Models\Template;

use App\Enums\StatusTermeContrat;
use App\Models\User;
use App\States\Terme\StatusTermeStateMachine;
use App\Traits\HasSites;
use Asantibanez\LaravelEloquentStateMachines\Traits\HasStateMachines;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin IdeHelperTermesContrat
 */
class TermesContrat extends Model
{
    use SoftDeletes, HasStateMachines, HasSites;

    protected $fillable = ['code', 'user_id', 'site_id', 'contenu', 'type', 'status'];

    const RULES = ['site_id' => 'required', 'contenu' => 'required'];

    /**
     * Summary of stateMachines
     * @var array<string, class-string>
     */
    public $stateMachines = [
        'status' => StatusTermeStateMachine::class,
    ];

    /**
     * Undocumented function
     *
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function used(): void
    {
        $this->status()->transitionTo(StatusTermeContrat::USING->value);
    }

    public function notUsed(): void
    {
        $this->status()->transitionTo(StatusTermeContrat::NOTUSING->value);
    }

    public function scopeIsUsed(Builder $query): Builder
    {
        return $query->whereHasStatus(fn (Builder $query) => $query->transitionedTo(StatusTermeContrat::USING->value));
    }

    public function scopeIsNotUsed(Builder $query): Builder
    {
        return $query->whereHasStatus(fn (Builder $query) => $query->transitionedTo(StatusTermeContrat::NOTUSING->value));
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo<User, TermesContrat>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
