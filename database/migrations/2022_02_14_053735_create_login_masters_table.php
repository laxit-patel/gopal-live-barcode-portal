<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('login_masters', function (Blueprint $table) {
            $table->increments('login_id');
            $table->string('name');
            $table->string('designation')->nullable();
            $table->json('role')->nullable();
            $table->string('username');
            $table->string('password');
            $table->integer('created_id');
            $table->timestamps();
        });
        DB::table('login_masters')->insert([
            array(
                'login_id' => 1,
                'name' => 'Master Admin',
                'designation' => 'Admin',
                'role' => 'admin',
                'username' => 'admin@aeonx.digital',
                'password' => '$2y$10$YpiOegPu6ogo6hQCbaY1tODv5O2A/elEcFnOOQnhGwkzPp1hLtACG',
                'created_id' => '0'
            )
        ]);
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('login_masters');
    }
};
