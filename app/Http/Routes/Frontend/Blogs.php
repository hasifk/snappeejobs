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
        get('advice', 'BlogsController@index')->name('Blogs.frontend.index');
        get('advice/{id}', 'BlogsController@show')->name('blogs.view');
        get('advice/next/{id}', 'BlogsController@next')->name('blogs.next');

    });

    /**
     * These routes require the user NOT be logged in
     */


});
