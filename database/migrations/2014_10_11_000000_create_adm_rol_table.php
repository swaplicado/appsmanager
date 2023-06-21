<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmRolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adm_roles', function (Blueprint $table) {
            $table->id('id_role');
            $table->string('role');
            $table->boolean('is_deleted');
        });

        DB::table('adm_roles')->insert([
            ['id_role' => 1, 'role' => 'Admin', 'is_deleted' => 0 ],
            ['id_role' => 2, 'role' => 'Proveedor', 'is_deleted' => 0 ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adm_roles');
    }
}
