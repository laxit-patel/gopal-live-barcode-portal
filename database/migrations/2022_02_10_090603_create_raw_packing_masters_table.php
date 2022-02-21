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
        Schema::create('raw_packing_masters', function (Blueprint $table) {
            $table->increments('raw_packing_id');
            $table->integer('machine_id');
            $table->integer('plant_id');
            $table->integer('line_id');
            $table->string('barcode');
            $table->integer('product_id');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('raw_packing_masters');
    }
};
