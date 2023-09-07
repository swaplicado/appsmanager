<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyLevelInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adm_permissions', function (Blueprint $table) {
            $table->dropForeign('adm_permissions_key_code_foreign');
        });
        
        Schema::table('adm_permissions', function (Blueprint $table) {
            $table->string('key_code', 100)->change();
            $table->string('level', 100)->change();
        });
        
        Schema::table('adm_permissions', function (Blueprint $table) {
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
        Schema::table('adm_permissions', function (Blueprint $table) {
            $table->dropForeign('adm_permissions_key_code_foreign');
        });
        
        Schema::table('adm_permissions', function (Blueprint $table) {
            $table->string('key_code', 20)->change();
            $table->string('level', 10)->change();
        });
        
        Schema::table('adm_permissions', function (Blueprint $table) {
            $table->foreign('key_code')->references('key_code')->on('adm_permission_keys');
        });
    }
}
