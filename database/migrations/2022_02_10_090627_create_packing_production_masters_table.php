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
        Schema::create('packing_production_masters', function (Blueprint $table) {
            $table->increments('packing_production_id');
            $table->string('production_voucher');
            $table->integer('plant_id');
            $table->integer('line_id');
            $table->string('barcode');
            $table->integer('product_id');
            $table->integer('qty');
            $table->string('unit');
            $table->integer('status')->default('0')->comment('api to share record');
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
        Schema::dropIfExists('packing_production_masters');
    }
};
