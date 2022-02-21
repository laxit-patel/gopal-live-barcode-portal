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
        Schema::create('product_masters', function (Blueprint $table) {
            $table->increments('product_id');
            $table->string('material_code')->unique();
            $table->string('description');
            $table->string('sales_organization');
            $table->string('barcode')->unique();
            $table->string('uom');
            $table->string('material_group');
            $table->string('material_group_description');
            $table->string('division');
            $table->string('division_description');
            $table->string('packet_per_box');
            $table->string('pending');
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
        Schema::dropIfExists('product_masters');
    }
};
