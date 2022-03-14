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
        Schema::create('processing_master', function (Blueprint $table) {
            $table->increments('id');
            $table->string('so_po_no');
            $table->string('plant_id');
            $table->string('line_id');
            $table->string('machine_id');
            $table->string('ip');
            $table->string('port');
            $table->string('pid')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('processing_master');
    }
};
