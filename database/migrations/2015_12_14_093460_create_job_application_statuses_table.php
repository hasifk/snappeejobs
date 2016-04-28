<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobApplicationStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_application_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('status', ['applied', 'feedback', 'interviewing', 'disqualified', 'hired']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('job_application_statuses');
    }
}
