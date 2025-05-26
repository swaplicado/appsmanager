<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertPermissionsRmIntoPermissionKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('adm_permission_keys')->insert([
            [ 
                'key_code' => 'user.own_rm',
                'description' => 'Permmisos de user RM',
                'app_n_id' => 2
            ]
        ]);

        DB::table('adm_permissions')->insert([
            [ 
                'app_n_id' => 2,
                'key_code' => 'user.own_rm',
                'level' => 'view',
                'description' => 'acceso a la vista de rm'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
