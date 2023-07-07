<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'names',
        'full_name',
        'is_active',
        'is_deleted',
        'created_by',
        'updated_by',
    ];

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

    public function types($apps){
        return $this->belongsToMany(Typesuser::class, 'adm_users_typesuser', 'user_id', 'typeuser_id')->whereIn('adm_users_typesuser.app_id', $apps);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'adm_user_roles','user_id', 'role_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'adm_user_permissions', 'user_id', 'role_id');
    }

    function isAdmin() : bool {
        $aRoles = $this->roles()
                    ->pluck('role_id')
                    ->toArray();

        return in_array(1, $aRoles);
    }
}
