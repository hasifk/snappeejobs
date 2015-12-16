<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threads', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('subject');
            $table->string('last_message');
            $table->integer('application_id')->unsigned()->nullable();
            $table->integer('employer_id')->unsigned()->nullable();
            $table->integer('message_count')->unsigned();
            $table->timestamps();

            $table->foreign('application_id')
                ->references('id')
                ->on('job_applications');
            $table->foreign('employer_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('threads', function (Blueprint $table) {
            $table->dropForeign('threads_application_id_foreign');
            $table->dropForeign('threads_employer_id_foreign');
        });

        Schema::drop('threads');
    }
}
