<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobVisitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_visitors', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('job_id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('country');
            $table->string('state')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('job_id')
                ->references('id')
                ->on('jobs')
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
        Schema::table('job_visitors', function (Blueprint $table) {
            $table->dropForeign('job_visitors_job_id_foreign');


        });

        Schema::drop('job_visitors');
    }
}
