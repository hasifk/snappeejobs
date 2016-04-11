<?php

$router->group([
    'middleware' => [
        'access.routeNeedsPermission:show-project',
        'access.routeNeedsSubscription',
        'access.routeNeedsCompany'
    ]
], function() use ($router)
{
    /**
     * Employer user Management
     */
    $router->group([ 'namespace' => 'Project' ], function() use ($router) {

        resource('projects', 'ProjectController');

        get('/assign-tasks/{id}', 'ProjectController@assignTasks')->name('admin.projects.assign-tasks');
        post('/create-task/{id}', 'ProjectController@storeTask')->name('admin.projects.createtask');
        get('/edit-task/{id}', 'ProjectController@editTask')->name('admin.projects.edittask');
        get('/show-task/{id}', 'ProjectController@showTask')->name('admin.projects.showtask');
        post('/update-task/{id}', 'ProjectController@updateTask')->name('admin.projects.updatetask');
        delete('/delete-task/{id}', 'ProjectController@deleteTask')->name('admin.projects.deletetask');

    });
});
