<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarbonFootPrintRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carbon_foot_print_records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('activity');
            $table->string('activityType');
            $table->string('country');
            $table->string('mode')->nullable();
            $table->string('fuelType')->nullable();
            $table->float('carbonFootprint');            
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
        Schema::dropIfExists('carbon_foot_print_records');
    }
}
