<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('names');
            $table->string('full_name');
            $table->rememberToken();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_deleted');
            $table->timestamps();
        });

        DB::table('users')->insert([
            [
                'id' => 1,
                'username' => 'admin',
                'email' => 'adrian.aviles@swaplicado.com.mx',
                'password' => \Hash::make('123456'),
                'first_name' => 'admin',
                'last_name' => 'admin',
                'names' => 'admin',
                'full_name' => 'Admin',
                'remember_token' => null,
                'is_active' => 1,
                'is_deleted' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
