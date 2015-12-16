<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people_company', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->string('name');
            $table->string('designation');
            $table->text('about_me');
            $table->string('path');
            $table->string('filename');
            $table->string('extension');
            $table->text('testimonial');
            $table->timestamps();

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
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
        Schema::table('people_company', function (Blueprint $table) {
            $table->dropForeign('people_company_company_id_foreign');
        });

        Schema::drop('people_company');
    }
}
