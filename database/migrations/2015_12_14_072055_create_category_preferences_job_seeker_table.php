<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryPreferencesJobSeekerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_preferences_job_seeker', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('job_category_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('job_seeker_details')
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
        Schema::table('category_preferences_job_seeker', function (Blueprint $table) {
            $table->dropForeign('category_preferences_job_seeker_user_id_foreign');
            $table->dropForeign('category_preferences_job_seeker_job_category_id_foreign');
        });

        Schema::drop('category_preferences_job_seeker');
    }
}
