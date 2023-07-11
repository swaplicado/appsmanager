<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_references', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('app_id');
            $table->string('reference');
            $table->string('foreing_column');
            $table->string('deleted_column')->nullable();
            $table->string('acitve_column')->nullable();
            $table->timestamps();

            $table->foreign('app_id')->references('id_app')->on('adm_apps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_references');
    }
}
