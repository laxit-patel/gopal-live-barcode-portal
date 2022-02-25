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
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('country')->nullable();
            $table->string('country_description')->nullable();
            $table->string('state')->nullable();
            $table->string('state_description')->nullable();
            $table->string('dealer_id')->nullable();
            $table->string('gst')->nullable();
            $table->string('pan')->nullable();
            $table->string('overall_block')->nullable();
            $table->string('overall_block_description')->nullable();
            $table->string('sales_organization')->nullable();
            $table->string('distribution_channel')->nullable();
            $table->string('distribution_channel_desc')->nullable();
            $table->string('price_group')->nullable();
            $table->string('price_group_description')->nullable();
            $table->string('price_list_type')->nullable();
            $table->string('price_list_type_description')->nullable();
            $table->string('plant')->nullable();
            $table->string('sold_to_party')->nullable();
            $table->string('ship_to_party_1')->nullable();
            $table->string('ship_to_party_2')->nullable();
            $table->string('ship_to_party_3')->nullable();
            $table->string('tax_classification')->nullable();
            $table->string('tax_classification_description')->nullable();
            $table->string('country_zone')->nullable();
            $table->string('country_zone_description')->nullable();
            $table->string('state_zone')->nullable();
            $table->string('state_zone_description')->nullable();
            $table->string('district_zone')->nullable();
            $table->string('district_zone_description')->nullable();
            $table->string('taluka_zone')->nullable();
            $table->string('taluka_zone_description')->nullable();
            $table->string('customer_account_group')->nullable();
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
