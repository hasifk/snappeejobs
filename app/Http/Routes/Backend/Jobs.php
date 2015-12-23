<?php

$router->group([
    'prefix' => 'employer',
    'namespace' => 'Employer',
    'middleware' => 'access.routeNeedsPermission:employer-jobs-view'
], function() use ($router)
{
    /**
     * Employer user Management
     */
    $router->group(['namespace' => 'Jobs'], function() use ($router) {

        resource('jobs', 'JobsController', ['except' => ['show']]);

        get('jobs/deactivated', 'JobsController@deactivated')->name('admin.employer.jobs.deactivated');
        get('jobs/banned', 'JobsController@banned')->name('admin.employer.jobs.banned');
        get('jobs/deleted', 'JobsController@deleted')->name('admin.employer.jobs.deleted');

    });
});