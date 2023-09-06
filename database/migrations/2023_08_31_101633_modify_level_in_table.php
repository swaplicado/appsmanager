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
            $table->string('key_code', 100)->change();
            $table->string('level', 100)->change();
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
            $table->string('key_code', 20)->change();
            $table->string('level', 10)->change();
        });
    }
}
