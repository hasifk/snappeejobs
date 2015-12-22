<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffEmployerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_employer', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employer_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->boolean('is_admin')->default(false);
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
        Schema::table('staff_employer', function (Blueprint $table) {
            $table->dropForeign('staff_employer_employer_id_foreign');
            $table->dropForeign('staff_employer_user_id_foreign');
        });

        Schema::drop('staff_employer');
    }
}
