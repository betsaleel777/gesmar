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
        'connected',
        'description',
        'adresse',
        'password',
        'avatar',
    ];

    const RULES = [
        'name' => 'required|max:150|unique:users,name',
        'email' => 'required|email|unique:users,email',
        'avatar' => 'required',
        'adresse' => 'required',
        'password' => 'required|min:6|confirmed',
    ];
    const SECURITY_RULES = [
        'oldPassword' => 'required|min:6',
        'password' => 'required|min:6|confirmed',
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
        $this->attributes['connected'] = false;
    }

    public function connecter()
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
    ];
}
