<?php

namespace App\Models;

use App\Traits\HasSites;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @mixin IdeHelperSociete
 */
class Societe extends Model implements HasMedia
{
    use HasSites, InteractsWithMedia;

    protected $fillable = ['nom', 'sigle', 'siege', 'capital'];

    protected $casts = ['capital' => 'integer'];
    protected $with = ['logo'];

    const RULES = [
        'nom' => 'required',
        'logo' => 'nullable|image',
        'siege' => 'required',
        'capital' => 'required|numeric',
        'sigle' => 'required|unique:societes,sigle',
    ];

    /**
     *
     * @return array<string, string>
     */
    public static function editRules(int $id): array
    {
        return [
            'nom' => 'required',
            'image' => 'nullable|image',
            'siege' => 'required',
            'capital' => 'required|numeric',
            'sigle' => 'required|unique:societes,sigle,' . $id,
        ];
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('preview')->fit(Manipulations::FIT_CROP, 300, 300)->nonQueued();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')->singleFile();
    }

    public function logo(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', '=', 'logo');
    }
}
