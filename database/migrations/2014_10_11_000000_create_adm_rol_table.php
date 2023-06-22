<?php

use Faker\Provider\Lorem;
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
            $table->string('role')->unique();
            $table->boolean('is_super')->default(false);
            $table->boolean('is_deleted')->default(false);
            $table->integer('app_n_id')->unsigned()->nullable();
            
            $table->foreign('app_n_id')->references('id_app')->on('adm_apps')->onDelete('restrict')->onUpdate('restrict');
        });

        DB::table('adm_roles')->insert([
            ['id_role' => 1, 'role' => 'Admin', 'is_deleted' => 0, 'app_n_id' => null ],
            ['id_role' => 2, 'role' => 'Proveedor', 'is_deleted' => 0, 'app_n_id' => null ],
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
