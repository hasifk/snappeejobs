<?php

$router->group([
    'prefix' => 'jobseekers',
    'namespace' => 'Jobseekers',
    'middleware' => ['access.routeNeedsPermission:view-access-management', 'access.routeNeedsRole:Administrator']
],function() use ($router){
    get('/', 'JobSeekerController@index')->name('backend.jobseekers');
    get('{id}', 'JobSeekerController@show')->name('backend.jobseekers.show');
    post('jobseeker/rate', 'JobSeekerController@rate')->name('backend.jobseekers.rate');
});

