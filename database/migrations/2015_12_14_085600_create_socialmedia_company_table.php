<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialmediaCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socialmedia_company', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->string('provider_name');
            $table->string('provider_id');
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
        Schema::table('socialmedia_company', function (Blueprint $table) {
            $table->dropForeign('socialmedia_company_company_id_foreign');
        });

        Schema::drop('socialmedia_company');
    }
}
