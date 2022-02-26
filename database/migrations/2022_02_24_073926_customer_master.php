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
        Schema::create('customer_master', function (Blueprint $table) {
            $table->increments('customer_id');
            $table->string('customer_number')->nullable(); 
            $table->string('name')->nullable();
            $table->string('street_1')->nullable();
            $table->string('street_2')->nullable();
            $table->string('street_3')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('sales_organization')->nullable();
            $table->string('distribution_channel')->nullable();
            $table->string('plant')->nullable();
            $table->string('sold_to_party')->nullable();
            $table->string('ship_to_party_1')->nullable();
            $table->string('ship_to_party_2')->nullable();
            $table->string('ship_to_party_3')->nullable();
            $table->string('price_group')->nullable();
            $table->string('price_list_type')->nullable();
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
        Schema::dropIfExists('customer_master');
    }
};
