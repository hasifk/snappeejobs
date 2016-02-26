<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployerAddonPackHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employer_addon_pack_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employer_id');
            $table->string('pack');
            $table->integer('job_postings');
            $table->integer('staff_members');
            $table->integer('chats_accepted');
            $table->integer('price');
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
        Schema::drop('employer_addon_pack_history');
    }
}
