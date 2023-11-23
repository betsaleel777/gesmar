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
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    /**
     * Undocumented function
     *
     * @param  int  $id
     * @return array<string, string>
     */
    public static function infosRules(int $id): array
    {
        return [
            'name' => 'required|max:150|unique:users,name,' . $id,
            'adresse' => 'required',
        ];
    }

    public function disconnect(): void
    {
        $this->attributes['connected'] = false;
    }

    public function connect(): void
    {
        $this->attributes['connected'] = true;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'connected' => 'boolean',
    ];

    /**
     * Summary of commercial
     * @return HasOne<Commercial>
     */
    public function commercial(): HasOne
    {
        return $this->hasOne(Commercial::class);
    }

    /**
     * Summary of caissier
     * @return HasOne<Caissier>
     */
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
