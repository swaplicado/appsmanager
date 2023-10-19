<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsActiveToAdmTypesuser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adm_typesuser', function (Blueprint $table) {
            $table->boolean('is_deleted')->default(0)->after('description');
            $table->boolean('is_active')->default(1)->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adm_typesuser', function (Blueprint $table) {
            $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
        });
    }
}
