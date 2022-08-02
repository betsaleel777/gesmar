<?php

namespace App\Models\Template;

use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin IdeHelperTermesContratEmplacement
 */
class TermesContratEmplacement extends TermesContrat
{
    protected $table = 'termes_contrats';

    private const TYPE = 'contrat de bail';

    /**
     * Undocumented function
     *
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->type = self::TYPE;
    }

    public function codeGenerate(): void
    {
        parent::generate('EMPL');
    }

    /**
     * Undocumented function
     *
     * @param  Builder<TermesContratEmplacement>  $query
     * @return Builder<TermesContratEmplacement>
     */
    public function scopeIsEmplacement(Builder $query): Builder
    {
        return $query->where('type', self::TYPE);
    }
}
