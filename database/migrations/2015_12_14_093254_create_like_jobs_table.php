<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikeJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('like_jobs', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('job_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('job_id')
                ->references('id')
                ->on('jobs')
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
        Schema::table('like_jobs', function (Blueprint $table) {
            $table->dropForeign('like_jobs_job_id_foreign');
            $table->dropForeign('like_jobs_user_id_foreign');
        });

        Schema::drop('like_jobs');
    }
}
