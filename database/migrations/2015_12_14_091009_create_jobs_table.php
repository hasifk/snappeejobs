<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->enum('level', ['internship', 'entry', 'mid', 'senior']);
            $table->integer('country_id')->unsigned();
            $table->integer('state_id')->unsigned();
            $table->integer('likes')->unsigned();
            $table->text('description');
            $table->timestamps();

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('state_id')
                ->references('id')
                ->on('states')
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
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropForeign('jobs_company_id_foreign');
            $table->dropForeign('jobs_country_id_foreign');
            $table->dropForeign('jobs_state_id_foreign');
        });

        Schema::drop('jobs');
    }
}
