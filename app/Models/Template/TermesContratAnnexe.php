<?php

namespace App\Models\Template;

use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin IdeHelperTermesContratAnnexe
 */
class TermesContratAnnexe extends TermesContrat
{
    protected $table = 'termes_contrats';

    private const TYPE = 'contrat annexe';

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
        parent::generate('ANEX');
    }

    /**
     * Undocumented function
     *
     * @param  Builder<TermesContratAnnexe>  $query
     * @return Builder<TermesContratAnnexe>
     */
    public function scopeIsAnnexe(Builder $query): Builder
    {
        return $query->where('type', self::TYPE);
    }
}
