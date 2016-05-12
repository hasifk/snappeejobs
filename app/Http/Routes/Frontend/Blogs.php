<?php

/**
 * Frontend Access Controllers
 */
$router->group(['namespace' => 'Blogs'], function () use ($router)
{
    /**
     * These routes require the user to be logged in
     */
    $router->group(['middleware' => 'auth'], function ()
    {
        get('blogs/manageblogs', 'BlogsController@index')->name('blogs.manageblogs');
        get('blogs/createblogs', 'BlogsController@createBlog')->name('blogs.create');
        post('blogs/saveblogs', 'BlogsController@saveBlog')->name('frontend.blogsave');
    });

    /**
     * These reoutes require the user NOT be logged in
     */


});
