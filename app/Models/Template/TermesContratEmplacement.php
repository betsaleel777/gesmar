<?php

namespace App\Models\Template;

use App\Events\TermeContratBailRegistred;
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
        $this->type = self::TYPE;
    }

    protected static function booted()
    {
        $type = self::TYPE;
        static::addGlobalScope('bail', function (Builder $builder) use ($type) {
            $builder->where('type', $type);
        });
        static::saved(function (TermesContratEmplacement $terme) {
            TermeContratBailRegistred::dispatch($terme);
        });
    }

    public function codeGenerate(): void
    {
        $rang = $this->count() + 1;
        $this->attributes['code'] = TEMPLATE_BAIL_PREFIXE . str_pad((string) $rang, 2, '0', STR_PAD_LEFT) . Carbon::now()->format('my');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(COLLECTION_MEDIA_CONTRAT_BAIL)->singleFile();
    }
}
