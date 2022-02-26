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
        Schema::create('sync', function (Blueprint $table) {
            $table->string('status')->comment('store status for failed sync every night');
            $table->string('description');
        }); //this table is purely used for storing status of sync between dealer portal and barcode portal
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sync');
    }
};
