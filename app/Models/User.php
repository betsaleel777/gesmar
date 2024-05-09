<?php

namespace App\Models;

use App\Models\Architecture\Site;
use App\Models\Bordereau\Commercial;
use App\Models\Caisse\Caissier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable implements HasMedia, Auditable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, InteractsWithMedia, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'email',
        'connected',
        'description',
        'adresse',
        'password',
    ];
    protected $auditExclude = ['connected'];
    const RULES = [
        'name' => 'required|max:150|unique:users,name',
        'email' => 'required|email|unique:users,email',
        'avatar' => 'required',
        'adresse' => 'required',
        'password' => 'required|min:6|confirmed',
        'sites' => 'required',
        'role_id' => 'required',
    ];

    const SECURITY_RULES = [
        'oldPassword' => 'required|min:6',
        'password' => 'required|min:6|confirmed',
    ];

    public static function infosRules(int $id): array
    {
        return [
            'name' => 'required|max:150|unique:users,name,' . $id,
            'adresse' => 'required',
        ];
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'connected' => 'boolean',
    ];

    public function disconnect(): void
    {
        $this->attributes['connected'] = false;
    }

    public function connect(): void
    {
        $this->attributes['connected'] = true;
    }

    public function commercial(): HasOne
    {
        return $this->hasOne(Commercial::class);
    }

    public function caissier(): HasOne
    {
        return $this->hasOne(Caissier::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')->singleFile();
    }

    public function avatar(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', '=', 'avatar');
    }

    public function sites(): BelongsToMany
    {
        return $this->belongsToMany(Site::class, 'site_attributions', 'user_id', 'site_id');
    }
}
