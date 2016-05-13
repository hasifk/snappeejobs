<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogSubCatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_sub_cats', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('blog_category_id')->unsigned();
            $table->string('name');
            $table->string('url_slug');
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
        Schema::table('blog_categories', function (Blueprint $table) {
            $table->dropForeign('blog_categories_blog_category_id_foreign');
        });
        Schema::drop('blog_sub_cats');
    }
}
