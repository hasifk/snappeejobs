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
            $table->string('resume_path');
            $table->string('resume_filename');
            $table->string('resume_extension');
            $table->enum('size', ['small', 'medium', 'big']);
            $table->integer('likes')->unsigned();
            $table->boolean('has_resume')->default(false);
            $table->boolean('preferences_saved')->default(false);

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
