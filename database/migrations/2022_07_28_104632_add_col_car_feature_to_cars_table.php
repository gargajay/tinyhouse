<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColCarFeatureToCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cars', function (Blueprint $table) {
            // $table->dropColumn('category_id');
            // $table->dropColumn('title');
            // $table->dropColumn('model');
            // $table->dropColumn('make');
            // $table->dropColumn('distance');
            // $table->dropColumn('lat');
            // $table->dropColumn('lng');
            // $table->dropColumn('car_number');
            // $table->dropColumn('geolocation');
            // $table->bigInteger('vehicle_companies_id')->nullable();
            // $table->bigInteger('vehicle_models_id')->nullable();
            // $table->string('registration_number')->nullable();
            // $table->string('engine_number')->nullable();
            // $table->string('meter_reading')->nullable();
            // $table->string('car_fuel_type')->nullable();
            // $table->string('car_number_plate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cars', function (Blueprint $table) {
            //
        });
    }
}
