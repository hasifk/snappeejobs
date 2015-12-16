<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThreadParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thread_participants', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('thread_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('sender_id')->unsigned();
            $table->timestamp('read_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('thread_id')
                ->references('id')
                ->on('threads')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::table('thread_participants', function (Blueprint $table) {
            $table->dropForeign('thread_participants_thread_id_foreign');
            $table->dropForeign('thread_participants_user_id_foreign');
            $table->dropForeign('thread_participants_sender_id_foreign');
        });

        Schema::drop('thread_participants');
    }
}
