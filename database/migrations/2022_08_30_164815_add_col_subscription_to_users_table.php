<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColSubscriptionToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('free_trail_days')->nullable();
            $table->date('free_trail_expiry_date')->nullable();
            $table->string('subscription_package_name')->nullable();
            $table->date('subscription_expiry_date')->nullable();
            $table->bigInteger('subscription_post_count')->nullable();
            $table->boolean('is_subscription')->default(false);
            $table->boolean('is_free_trail')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
