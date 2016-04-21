<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobApplicationStatusHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_application_status_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_application_id')->unsigned();
            $table->integer('job_application_status_company_id')->unsigned();
            $table->timestamps();

            $table->foreign('job_application_id')
                ->references('id')
                ->on('job_applications')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('job_application_status_company_id','jb_apst_cmp')
                ->references('id')
                ->on('job_application_status_company')
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
        Schema::table('job_application_status_history', function (Blueprint $table) {
            $table->dropForeign('job_application_status_history_job_application_id_foreign');
            $table->dropForeign('job_application_status_history_jb_apst_cmp_foreign');
        });

        Schema::drop('job_application_status_history');
    }
}
