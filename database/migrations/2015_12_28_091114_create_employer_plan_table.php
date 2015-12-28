<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployerPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employer_plan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employer_id')->unsigned();
            $table->integer('job_postings')->unsigned();
            $table->integer('staff_members')->unsigned();
            $table->integer('chats_accepted')->unsigned();
            $table->timestamps();

            $table->foreign('employer_id')
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
        Schema::table('employer_plan', function (Blueprint $table) {
            $table->dropForeign('employer_plan_employer_id_foreign');
        });

        Schema::drop('employer_plan');
    }
}
