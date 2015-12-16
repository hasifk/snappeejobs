<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryPreferencesJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_preferences_jobs', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('job_id')->unsigned();
            $table->integer('job_category_id')->unsigned();
            $table->timestamps();

            $table->foreign('job_id')
                ->references('id')
                ->on('jobs')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('job_category_id')
                ->references('id')
                ->on('job_categories')
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
        Schema::table('category_preferences_jobs', function (Blueprint $table) {
            $table->dropForeign('category_preferences_jobs_job_id_foreign');
            $table->dropForeign('category_preferences_jobs_job_category_id_foreign');
        });

        Schema::drop('category_preferences_jobs');
    }
}
