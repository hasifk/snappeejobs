<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployerNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employer_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employer_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->enum('notification_type', [
                'company_information_updated',
                'job_created',
                'job_updated',
                'job_deleted',
                'project_created',
                'project_updated',
                'project_deleted',
                'task_created',
                'task_updated',
                'task_deleted'
            ]);
            $table->timestamp('read_at')->nullable();
            $table->binary('details');
            $table->timestamps();

            $table->foreign('employer_id')
                ->references('id')
                ->on('users')
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
        Schema::table('employer_notifications', function (Blueprint $table) {
            $table->dropForeign('employer_notifications_employer_id_foreign');
            $table->dropForeign('employer_notifications_user_id_foreign');
        });

        Schema::drop('employer_notifications');
    }
}
