<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobSeekerImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_seeker_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('filename');
            $table->string('path');
            $table->string('extension');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('job_seeker_details')
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
        Schema::table('job_seeker_images', function (Blueprint $table) {
            $table->dropForeign('job_seeker_images_user_id_foreign');
        });

        Schema::drop('job_seeker_images');
    }
}
