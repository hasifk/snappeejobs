<?php

$router->group([
    'prefix' => 'jobseekers',
    'namespace' => 'Jobseekers',
    'middleware' => ['access.routeNeedsPermission:view-access-management', 'access.routeNeedsRole:Administrator']
],function() use ($router){
    get('/', 'JobSeekerController@index')->name('backend.jobseekers');
    get('jobseeker/{id}', 'JobSeekerController@show')->name('backend.jobseekers.show');
});


$router->group([
    'prefix' => 'empjobseekers',
    'namespace' => 'Jobseekers',
    'middleware' => ['access.routeNeedsPermission:employer-users-view', 'access.routeNeedsRole:Employer']
],function() use ($router){
    get('/', 'EmpJobSeekerController@index')->name('backend.employerjobseekers');
    get('{id}', 'EmpJobSeekerController@show')->name('backend.employerjobseekers.show');
    post('jobseeker/rate', 'EmpJobSeekerController@rate')->name('backend.employerjobseekers.rate');
});

