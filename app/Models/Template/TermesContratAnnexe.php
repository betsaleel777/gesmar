<?php

namespace App\Models\Template;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @mixin IdeHelperTermesContratAnnexe
 */
class TermesContratAnnexe extends TermesContrat implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'termes_contrats';
    private const TYPE = 'contrat annexe';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    protected static function booted(): void
    {
        parent::boot();
        static::addGlobalScope('annexe', fn (Builder $builder): Builder => $builder->where('type', self::TYPE));
    }

    public function codeGenerate(): void
    {
        $rang = $this->whereYear('created_at', Carbon::now()->format('Y'))->withTrashed()->count() + 1;
        $this->attributes['code'] = config('constants.TEMPLATE_ANNEXE_PREFIXE') . str_pad((string) $rang, 2, '0', STR_PAD_LEFT) . Carbon::now()->format('my');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(config('constants.COLLECTION_MEDIA_CONTRAT_ANNEXE'))->singleFile();
    }
}
