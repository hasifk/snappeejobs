<?php

/**
 * Backend Access Controllers
 */
$router->group(['namespace' => 'Blogs'], function () use ($router)
{
    /**
     * These routes require the user to be logged in
     */
    $router->group([], function ()
    {
        get('blogs/manageblogs', 'BlogsController@index')->name('Blogs');
        get('blogs/createblogs', 'BlogsController@createBlog')->name('Blogs.create');
        get('blogs/editblogs/{id}', 'BlogsController@editBlog')->name('Blogs.edit');
        post('blogs/saveblogs', 'BlogsController@saveBlog')->name('frontend.blogsave');
        get('get-subcats/{id}', function($id){
            $sub_cats = DB::table('blog_sub_cats')->where('blog_category_id', $id)->select(['id', 'name'])->get();
            return response()->json($sub_cats);
        });
    });

    /**
     * These reoutes require the user NOT be logged in
     */


});
