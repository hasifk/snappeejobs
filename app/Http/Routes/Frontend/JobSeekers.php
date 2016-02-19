<?php

/**
 * Frontend Access Controllers
 */
$router->group(['namespace' => 'JobSeekers'], function () use ($router)
{
    /**
     * These routes require the user to be logged in
     */
    $router->group(['middleware' => 'auth'], function ()
    {

    });

    /**
     * These reoutes require the user NOT be logged in
     */
    get('jobseekers', 'JobSeekerController@index')->name('jobseeker.search');
    get('jobseeker/{id}', 'JobSeekerController@show')->name('jobseeker.show');
    post('jobseeker/like', 'JobSeekerController@likeJob')->name('jobseeker.like');
});
