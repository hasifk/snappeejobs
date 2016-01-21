<?php

/**
 * Frontend Job Controllers
 */

$router->group(['namespace' => 'Job'], function () use ($router)
{

    get('jobs', 'JobsController@index')->name('jobs.search');
    get('job/{company}/{slug}', 'JobsController@show')->name('jobs.view');

    $router->group(['middleware' => 'auth'], function () use ($router)
    {

    });

});