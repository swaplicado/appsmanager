<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    use HasFactory;

    protected $table = 'adm_user_roles';
    protected $primaryKey = 'id';
    protected $fillable = [
        'app_n_id',
        'user_id',
        'role_id',
    ];
    public $timestamps = false;
}
