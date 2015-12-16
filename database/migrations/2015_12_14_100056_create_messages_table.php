<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id')->unsigned();
            $table->integer('thread_id')->unsigned();
            $table->integer('sender_id')->unsigned();
            $table->text('content');
            $table->timestamps();

            $table->foreign('thread_id')
                ->references('id')
                ->on('threads')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('sender_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign('messages_thread_id_foreign');
            $table->dropForeign('messages_sender_id_foreign');
        });

        Schema::drop('messages');
    }
}
