<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobApplicationStatusCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_application_status_company', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employer_id')->unsigned();
            $table->integer('job_application_status_id')->unsigned();
            $table->string('name');
            $table->timestamps();

            $table->foreign('employer_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('job_application_status_id')
                ->references('id')
                ->on('job_application_statuses')
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
        Schema::table('job_application_status_company', function (Blueprint $table) {
            $table->dropForeign('job_application_status_company_employer_id_foreign');
            $table->dropForeign('job_application_status_company_job_application_status_id_foreign');
        });

        Schema::drop('job_application_status_company');
    }
}
