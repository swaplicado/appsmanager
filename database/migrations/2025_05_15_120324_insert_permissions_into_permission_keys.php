<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertPermissionsIntoPermissionKeys extends Migration
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
                'key_code' => 'autorizador.rm',
                'description' => 'Permmisos de autorizador RM',
                'app_n_id' => 2
            ]
        ]);

        DB::table('adm_permissions')->insert([
            [ 
                'app_n_id' => 2,
                'key_code' => 'autorizador.rm',
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
