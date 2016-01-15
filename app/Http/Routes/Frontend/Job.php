<?php

/**
 * Frontend Job Controllers
 */

$router->group(['namespace' => 'Job'], function () use ($router)
{

    get('jobs', 'JobsController@index')->name('jobs.search');
    get('job/{company}/{slug}', 'JobsController@show')->name('jobs.view')->where(['company' => '[a-zA-Z]+', 'slug' => '[a-zA-Z]+']);

    $router->group(['middleware' => 'auth'], function () use ($router)
    {

    });

});