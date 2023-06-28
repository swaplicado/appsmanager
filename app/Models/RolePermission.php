<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;

    protected $table = 'adm_roles_permissions';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'app_n_id',
        'role_id',
        'permission_id'
    ];
}
