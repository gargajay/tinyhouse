<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('chat_id')->unsigned();
            $table->foreign('chat_id')->references('id')->on('chats')->onDelete('cascade');
            $table->bigInteger('sent_by')->unsigned();
            $table->foreign('sent_by')->references('id')->on('users')->onDelete('cascade');
            $table->text('message')->nullable();
            $table->string('file')->nullable()->default("");
            $table->string('file_type')->nullable()->default("");
            $table->string('file_extension', 50)->nullable()->default("");
            $table->enum('type', ['text', 'file']);
            $table->enum('is_seen', ['0', '1'])->default('0');
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
        Schema::dropIfExists('messages');
    }
}
