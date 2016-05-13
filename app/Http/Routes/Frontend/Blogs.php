<?php

/**
 * Frontend Access Controllers
 */
$router->group(['namespace' => 'Blogs'], function () use ($router)
{
    /**
     * These routes require the user to be logged in
     */
    $router->group([], function ()
    {
        get('get-blogs', 'BlogsController@index')->name('Blogs.frontend.index');
        get('getblogs/{id}', 'BlogsController@show')->name('blogs.view');
        get('getblogs/next/{id}', 'BlogsController@next')->name('blogs.next');

    });

    /**
     * These routes require the user NOT be logged in
     */


});
