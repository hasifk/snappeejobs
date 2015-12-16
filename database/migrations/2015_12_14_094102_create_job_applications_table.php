<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('job_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamp('accepted_at')->nullable();
            $table->integer('accepted_by')->unsigned();
            $table->timestamp('declined_at')->nullable();
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
            $table->foreign('accepted_by')
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
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropForeign('job_applications_job_id_foreign');
            $table->dropForeign('job_applications_user_id_foreign');
            $table->dropForeign('job_applications_accepted_by_foreign');
        });

        Schema::drop('job_applications');
    }
}
