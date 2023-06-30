<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermissions extends Model
{
    use HasFactory;

    protected $table = "adm_user_permissions";
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable = [
        'app_n_id',
        'user_id',
        'permission_id',
        'is_blocked'
    ];
}
