<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobSeekerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_seeker_details', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('country_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->string('resume_path')->nullable();
            $table->string('resume_filename')->nullable();
            $table->string('resume_extension')->nullable();
            $table->enum('size', ['small', 'medium', 'big'])->default('medium')->nullable();
            $table->integer('likes')->unsigned()->nullable();
            $table->boolean('has_resume')->default(false);
            $table->boolean('preferences_saved')->default(false);
            $table->integer('profile_completeness')->default(0);

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
        Schema::table('job_seeker_details', function (Blueprint $table) {
            $table->dropForeign('job_seeker_details_user_id_foreign');
        });

        Schema::drop('job_seeker_details');
    }
}
