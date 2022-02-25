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
        Schema::create('order_masters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('so_po_no')->unique()->nullable();
            $table->string('customer_id')->nullable();
            $table->string('sold_to')->nullable();
            $table->string('sales_org')->nullable();
            $table->string('line_no')->nullable();
            $table->string('dist_chan')->nullable();
            $table->string('po_no')->nullable();
            $table->string('plant')->nullable();
            $table->string('total')->nullable();
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
        Schema::dropIfExists('order_masters');
    }
};
