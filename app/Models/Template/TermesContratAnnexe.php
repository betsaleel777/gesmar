<?php

namespace App\Models\Template;

use Carbon\Carbon;
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
        $rang = $this->count() + 1;
        $this->attributes['code'] = TEMPLATE_ANNEXE_PREFIXE . str_pad((string) $rang, 2, '0', STR_PAD_LEFT) . Carbon::now()->format('my');
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
