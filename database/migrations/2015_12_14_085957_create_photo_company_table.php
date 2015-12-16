<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotoCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photo_company', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->string('path');
            $table->string('filename');
            $table->string('extension');
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
        Schema::table('photo_company', function (Blueprint $table) {
            $table->dropForeign('photo_company_company_id_foreign');
        });

        Schema::drop('photo_company');
    }
}
