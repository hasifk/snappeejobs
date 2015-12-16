<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationJobApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_job_application', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('job_application_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamp('viewed_at')->nullable();
            $table->timestamps();

            $table->foreign('job_application_id')
                ->references('id')
                ->on('job_applications')
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
        Schema::table('notification_job_application', function (Blueprint $table) {
            $table->dropForeign('notification_job_application_job_application_id_foreign');
            $table->dropForeign('notification_job_application_user_id_foreign');
        });

        Schema::drop('notification_job_application');
    }
}
