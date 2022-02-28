<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('access_master', function (Blueprint $table) {
            $table->increments('access_id');
            $table->string('role');
            $table->string('plant');
            $table->string('line');
        }); //this table is purely used for storing status of sync between dealer portal and barcode portal
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('access_master');
    }
};
