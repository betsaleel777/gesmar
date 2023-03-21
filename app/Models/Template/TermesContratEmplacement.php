<?php

namespace App\Models\Template;

use Carbon\Carbon;
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
        $rang = $this->count() + 1;
        $this->attributes['code'] = TEMPLATE_BAIL_PREFIXE . str_pad((string) $rang, 2, '0', STR_PAD_LEFT) . Carbon::now()->format('my');
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
