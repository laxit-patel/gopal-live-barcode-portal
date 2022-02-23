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
        Schema::create('dispatch_masters', function (Blueprint $table) {
            $table->increments('dispatch_id');
            $table->string('sales_voucher');
            $table->string('so_po_no');
            $table->string('item_no');
            $table->integer('plant_id');
            $table->integer('line_id');
            $table->string('barcode');
            $table->integer('product_id');
            $table->integer('qty');
            $table->string('unit');
            $table->integer('updated_id')->nullable();
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
        Schema::dropIfExists('dispatch_masters');
    }
};
