<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apps extends Model
{
    use HasFactory;

    protected $table = 'adm_apps';
    protected $primaryKey = 'id_app';
    protected $fillable = [
        'name',
        'app_url',
        'target',
        'description',
        'is_active'
    ];
}
