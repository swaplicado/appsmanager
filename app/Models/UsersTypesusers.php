<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersTypesusers extends Model
{
    use HasFactory;

    protected $table = "adm_users_typesuser";
    protected $primaryKey = "id";
    protected $fillable = [
        'user_id',
        'app_id',
        'typeuser_id',
    ];
}
