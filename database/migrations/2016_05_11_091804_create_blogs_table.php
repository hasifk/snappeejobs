<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('blog_category_id')->unsigned();
            $table->integer('blog_sub_cat_id')->unsigned();
            $table->string('title');
            $table->string('avatar_filename');
            $table->string('avatar_extension');
            $table->string('avatar_path');
            $table->longText('content');
            $table->string('youtube_id');
            $table->string('vimeo_id');
            $table->dateTime('approved_at')->nullable()->default(null);
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_user_id_foreign');
        });
        Schema::table('blog_categories', function (Blueprint $table) {
            $table->dropForeign('blog_categories_blog_category_id_foreign');
        });
        Schema::table('blog_sub_cats', function (Blueprint $table) {
            $table->dropForeign('blog_sub_cats_blog_sub_cat_id_foreign');
        });
        Schema::drop('blog_sub_cats');
    }
}
