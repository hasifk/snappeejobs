<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->string('url_slug');
            $table->enum('size', ['small', 'medium', 'big']);
            $table->text('description');
            $table->text('what_it_does');
            $table->text('office_life');
            $table->integer('country_id')->unsigned();
            $table->integer('state_id')->unsigned();
            $table->integer('default_photo_id')->unsigned();
            $table->string('logo');
            $table->integer('likes')->unsigned();
            $table->timestamps();

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
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign('companies_country_id_foreign');
            $table->dropForeign('companies_state_id_foreign');
        });

        Schema::drop('companies');
    }
}
