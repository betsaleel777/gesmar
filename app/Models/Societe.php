<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @mixin IdeHelperSociete
 */
class Societe extends Model implements HasMedia, Auditable
{
    use InteractsWithMedia;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['nom', 'sigle', 'siege', 'capital', 'smartphone', 'email', 'phone'];

    protected $casts = ['capital' => 'integer'];
    protected $with = ['logo'];

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
        $this->addMediaCollection(config('constants.COLLECTION_MEDIA_LOGO'))->singleFile();
    }

    public function logo(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', '=', config('constants.COLLECTION_MEDIA_LOGO'));
    }
}
