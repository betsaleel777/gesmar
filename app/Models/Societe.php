<?php

namespace App\Models;

use App\Traits\HasSites;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Manipulations;

/**
 * @mixin IdeHelperSociete
 */
class Societe extends Model implements HasMedia
{
    use HasSites, InteractsWithMedia;

    protected $fillable = ['nom', 'sigle', 'siege', 'capital', 'smartphone', 'email', 'phone'];

    protected $casts = ['capital' => 'integer'];
    protected $with = [COLLECTION_MEDIA_LOGO];

    const RULES = [
        'nom' => 'required',
        'logo' => 'nullable|image',
        'siege' => 'required',
        'capital' => 'required|numeric',
        'sigle' => 'required',
        'smartphone' => 'required',
        'phone' => 'required',
        'email' => 'required|email',
    ];
    const EDIT_RULES = [
        'nom' => 'required',
        'siege' => 'required',
        'capital' => 'required|numeric',
        'sigle' => 'required',
        'smartphone' => 'required',
        'phone' => 'required',
        'email' => 'required|email',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('preview')->fit(Manipulations::FIT_CROP, 300, 300)->nonQueued();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(COLLECTION_MEDIA_LOGO)->singleFile();
    }

    public function logo(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', '=', COLLECTION_MEDIA_LOGO);
    }
}
