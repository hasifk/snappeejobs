<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupMessageMentionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_message_mentions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_message_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->foreign('group_message_id')
                ->references('id')
                ->on('group_messages')
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
        Schema::table('group_message_mentions', function (Blueprint $table) {
            $table->dropForeign('group_message_mentions_group_message_id_foreign');
            $table->dropForeign('group_message_mentions_user_id_foreign');
        });

        Schema::drop('group_message_mentions');
    }
}
