<?php

/**
 * Frontend Job Controllers
 */

$router->group(['namespace' => 'Job'], function () use ($router)
{

    get('jobs', 'JobsController@index')->name('jobs.search');
    get('job/next/{job}', 'JobsController@next')->name('jobs.next');
    get('job/{company}/{slug}', 'JobsController@show')->name('jobs.view');
    post('jobs/job/like', 'JobsController@likeJob')->name('job.like');
    post('jobs/job/dislike', 'JobsController@dislikeJob')->name('job.dislike');
    post('jobs/job/flag', 'JobsController@flagJob')->name('job.flag');
    post('jobs/job/apply', 'JobsController@applyJob')->name('job.apply');
    post('jobs/matchedJobs', 'JobsController@matchedJobs')->name('job.matchedjobs');

    $router->group(['middleware' => 'auth'], function () use ($router)
    {

    });

});
