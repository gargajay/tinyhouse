<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('message')->nullable();
            $table->string('type')->nullable();
            $table->text('data')->nullable();
            $table->bigInteger('car_id')->unsigned()->nullable();
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
            $table->enum('is_seen', ['0', '1'])->default('0');
            $table->bigInteger('notification_from')->unsigned()->nullable();
            $table->foreign('notification_from')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('booking_id')->unsigned()->nullable();
        //    $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->string('is_read', 10)->default('0');
            $table->string('giver_id')->nullable();
            $table->longText('receiver_msg')->nullable();
            $table->string('status')->default('1')->comment('1 => pending, 2 => accepted, 3 => rejected');
            $table->timestamps();
            $table->softDeletes();
        });
    }
    
   
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
