<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adm_permissions', function (Blueprint $table) {
            $table->id('id_permission');
            $table->integer('app_n_id')->unsigned()->nullable();
            $table->string('key_code', 20);
            $table->string('level', 10);
            $table->string('description');

            $table->foreign('app_n_id')->references('id_app')->on('adm_apps')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('key_code')->references('key_code')->on('adm_permission_keys');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adm_permissions');
    }
}
