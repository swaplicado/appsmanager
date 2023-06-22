<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdmPermissionKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adm_permission_keys', function (Blueprint $table) {
            $table->string('key_code', 20)->primary();
            $table->string('description')->nullable();
            $table->integer('app_n_id')->unsigned()->nullable();

            $table->foreign('app_n_id')->references('id_app')->on('adm_apps')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adm_permission_keys');
    }
}
