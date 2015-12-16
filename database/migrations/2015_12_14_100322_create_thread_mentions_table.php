<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThreadMentionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thread_mentions', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('message_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamp('notified_at')->nullable();
            $table->timestamps();

            $table->foreign('message_id')
                ->references('id')
                ->on('messages')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('user_id')
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
        Schema::table('thread_mentions', function (Blueprint $table) {
            $table->dropForeign('thread_mentions_message_id_foreign');
            $table->dropForeign('thread_mentions_user_id_foreign');
        });

        Schema::drop('thread_mentions');
    }
}
