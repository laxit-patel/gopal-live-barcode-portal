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
        Schema::create('barcode_machine_masters', function (Blueprint $table) {
            $table->increments('machine_id');
            $table->enum('type', ['packing', 'dispatch']);
            $table->string('ip_address');
            $table->string('port');
            $table->integer('plant_id');
            $table->integer('line_id');
            $table->integer('created_id');
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
        Schema::dropIfExists('barcode_machine_masters');
    }
};
