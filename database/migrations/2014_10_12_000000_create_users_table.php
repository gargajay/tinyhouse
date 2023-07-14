<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Grammer\ExtendedPostgresGrammar;
use App\Helper\general_helper;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('facebook_id', 255)->nullable();
            $table->string('google_id', 255)->nullable();
            $table->string('apple_id', 255)->nullable();
            $table->string('username')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('country_code', 10)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('image')->nullable();
            $table->string('lat', 50)->nullable();
            $table->string('lng', 50)->nullable();
            $table->string('device_type', 10)->nullable();
            $table->text('device_token')->nullable();
            $table->enum('status', [0, 1])->default(1);
            $table->enum('user_type', ['seller', 'buyer', 'admin'])->default('buyer');
            $table->point('geolocation')->nullable();
            $table->boolean('is_info')->default('false');
            $table->longText('description')->nullable();
            $table->string('is_status')->default('Enable')->comment('Enable, Disable , Delete');
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
