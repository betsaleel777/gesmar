<?php

namespace App\Models\Template;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @mixin IdeHelperTermesContratEmplacement
 */
class TermesContratEmplacement extends TermesContrat implements HasMedia
{
    use InteractsWithMedia;

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
    }

    protected static function booted(): void
    {
        parent::boot();
        static::addGlobalScope('bail', fn(Builder $builder): Builder => $builder->where('type', self::TYPE));
    }

    public function codeGenerate(): void
    {
        $rang = empty($this->latest()->first()) ? 1 : $this->latest()->first()->id;
        $this->attributes['code'] = TEMPLATE_BAIL_PREFIXE . str_pad((string) $rang, 2, '0', STR_PAD_LEFT) . Carbon::now()->format('my');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(COLLECTION_MEDIA_CONTRAT_BAIL)->singleFile();
    }
}
