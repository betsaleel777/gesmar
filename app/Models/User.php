<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'status',
        'description',
        'adresse',
        'password',
        'avatar',
    ];

    protected $dates = ['created_at'];
    const CONNECTED = 'connecté';
    const DISCONNECTED = 'pas connecté';
    const RULES = [
        'name' => 'required|max:150|unique:users,name',
        'email' => 'required|email|unique:users,email',
        'avatar' => 'required',
        'adresse' => 'required',
        'password' => 'required|min:6|confirmed',
    ];
    const SECURITE_RULE = [
        'oldPassword' => 'required|min:6',
        'password' => 'required|min:6|confirmed',
    ];
    const ACTIVE_PANEL = [
        'info' => 'information',
        'perm' => 'permission',
        'noti' => 'notification',
        'secu' => 'securite',
        'comp' => 'compte',
    ];

    public static function infosRules(int $id)
    {
        return [
            'name' => 'required|max:150|unique:users,name,' . $id,
            'adresse' => 'required',
        ];
    }

    public function deconnecter()
    {
        $this->attributes['status'] = self::DISCONNECTED;
    }

    public function connecter()
    {
        $this->attributes['status'] = self::CONNECTED;
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
    ];
}
