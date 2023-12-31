<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmRolesPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adm_roles_permissions', function (Blueprint $table) {
            $table->id();
            $table->integer('app_n_id')->unsigned()->nullable();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('permission_id');
            
            $table->foreign('app_n_id')->references('id_app')->on('adm_apps')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('role_id')->references('id_role')->on('adm_roles')->onDelete('cascade');
            $table->foreign('permission_id')->references('id_permission')->on('adm_permissions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adm_roles_permissions');
    }
}
