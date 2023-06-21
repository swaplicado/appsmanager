<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_role';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'adm_roles';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class, 'adm_user_roles');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'adm_roles_permissions');
    }
}
